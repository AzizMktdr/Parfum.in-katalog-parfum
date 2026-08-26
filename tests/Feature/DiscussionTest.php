<?php

namespace Tests\Feature;

use App\Models\Discussion;
use App\Models\DiscussionReply;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiscussionTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_community_bisa_dibuka_tanpa_login(): void
    {
        $discussion = Discussion::factory()->create(['title' => 'Rekomendasi Parfum Kerja']);

        $this->get(route('community'))
            ->assertStatus(200)
            ->assertSee($discussion->title);
    }

    public function test_guest_tidak_bisa_membuat_diskusi(): void
    {
        $this->post(route('discussion.store'), [
            'title' => 'Judul Tamu',
            'body'  => 'Isi diskusi dari tamu.',
        ])->assertRedirect(route('login'));

        $this->assertDatabaseCount('discussions', 0);
    }

    public function test_user_bisa_membuat_diskusi(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('discussion.store'), [
            'title' => 'Parfum Untuk Cuaca Panas',
            'body'  => 'Ada rekomendasi yang tahan lama?',
        ])->assertRedirect();

        $this->assertDatabaseHas('discussions', [
            'user_id' => $user->id,
            'title'   => 'Parfum Untuk Cuaca Panas',
        ]);
    }

    public function test_judul_dan_isi_diskusi_wajib_diisi(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('community'))
            ->post(route('discussion.store'), ['title' => '', 'body' => ''])
            ->assertSessionHasErrors(['title', 'body']);
    }

    public function test_halaman_detail_diskusi_menampilkan_balasan(): void
    {
        $discussion = Discussion::factory()->create();
        $reply      = DiscussionReply::factory()->create([
            'discussion_id' => $discussion->id,
            'body'          => 'Saya pakai yang ini juga.',
        ]);

        $this->get(route('discussion.show', $discussion))
            ->assertStatus(200)
            ->assertSee($discussion->title)
            ->assertSee($reply->body);
    }

    public function test_balasan_menambah_counter_replies_count(): void
    {
        $user       = User::factory()->create();
        $discussion = Discussion::factory()->create();

        $this->actingAs($user)
            ->post(route('discussion.reply', $discussion), ['body' => 'Setuju banget.'])
            ->assertRedirect();

        $this->assertDatabaseHas('discussion_replies', [
            'discussion_id' => $discussion->id,
            'user_id'       => $user->id,
            'body'          => 'Setuju banget.',
        ]);
        $this->assertSame(1, $discussion->fresh()->replies_count);
    }

    public function test_menghapus_balasan_mengurangi_counter(): void
    {
        $user       = User::factory()->create();
        $discussion = Discussion::factory()->create(['replies_count' => 1]);
        $reply      = DiscussionReply::factory()->create([
            'discussion_id' => $discussion->id,
            'user_id'       => $user->id,
        ]);

        $this->actingAs($user)
            ->delete(route('discussion.reply.destroy', $reply))
            ->assertRedirect();

        $this->assertDatabaseCount('discussion_replies', 0);
        $this->assertSame(0, $discussion->fresh()->replies_count);
    }

    public function test_balasan_bertingkat_harus_dari_diskusi_yang_sama(): void
    {
        $user        = User::factory()->create();
        $discussionA = Discussion::factory()->create();
        $discussionB = Discussion::factory()->create();
        $replyDiB    = DiscussionReply::factory()->create(['discussion_id' => $discussionB->id]);

        $this->actingAs($user)
            ->from(route('discussion.show', $discussionA))
            ->post(route('discussion.reply', $discussionA), [
                'body'      => 'Balasan nyasar.',
                'parent_id' => $replyDiB->id,
            ])
            ->assertSessionHasErrors('parent_id');

        $this->assertDatabaseCount('discussion_replies', 1);
    }

    public function test_like_diskosi_hanya_dihitung_sekali_per_user(): void
    {
        $user       = User::factory()->create();
        $discussion = Discussion::factory()->create();

        $this->actingAs($user)
            ->postJson(route('discussion.like', $discussion))
            ->assertJson(['liked' => true, 'count' => 1]);

        $this->assertSame(1, $discussion->fresh()->likes_count);

        $this->actingAs($user)
            ->postJson(route('discussion.like', $discussion))
            ->assertJson(['liked' => false, 'count' => 0]);

        $this->assertSame(0, $discussion->fresh()->likes_count);
        $this->assertDatabaseCount('discussion_likes', 0);
    }

    public function test_hanya_pemilik_yang_bisa_menghapus_diskusi(): void
    {
        $owner      = User::factory()->create();
        $orangLain  = User::factory()->create();
        $discussion = Discussion::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($orangLain)
            ->delete(route('discussion.destroy', $discussion))
            ->assertStatus(403);

        $this->actingAs($owner)
            ->delete(route('discussion.destroy', $discussion))
            ->assertRedirect(route('community', ['tab' => 'discussions']));

        $this->assertDatabaseCount('discussions', 0);
    }

    public function test_hanya_pemilik_balasan_yang_bisa_menghapusnya(): void
    {
        $discussion = Discussion::factory()->create();
        $reply      = DiscussionReply::factory()->create(['discussion_id' => $discussion->id]);
        $orangLain  = User::factory()->create();

        $this->actingAs($orangLain)
            ->delete(route('discussion.reply.destroy', $reply))
            ->assertStatus(403);

        $this->assertDatabaseCount('discussion_replies', 1);
    }

    public function test_menghapus_diskusi_ikut_menghapus_balasannya(): void
    {
        $owner      = User::factory()->create();
        $discussion = Discussion::factory()->create(['user_id' => $owner->id]);
        DiscussionReply::factory()->count(2)->create(['discussion_id' => $discussion->id]);

        $this->actingAs($owner)->delete(route('discussion.destroy', $discussion));

        $this->assertDatabaseCount('discussion_replies', 0);
    }
}
