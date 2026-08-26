<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FollowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_tidak_bisa_follow(): void
    {
        $target = User::factory()->create();

        $this->post(route('follow.toggle', $target))->assertRedirect(route('login'));

        $this->assertDatabaseCount('follows', 0);
    }

    public function test_user_bisa_follow_lalu_unfollow(): void
    {
        $me     = User::factory()->create();
        $target = User::factory()->create();

        $this->actingAs($me)
            ->postJson(route('follow.toggle', $target))
            ->assertJson(['following' => true, 'followers_count' => 1]);

        $this->assertTrue($me->fresh()->isFollowing($target));

        $this->actingAs($me)
            ->postJson(route('follow.toggle', $target))
            ->assertJson(['following' => false, 'followers_count' => 0]);

        $this->assertFalse($me->fresh()->isFollowing($target));
        $this->assertDatabaseCount('follows', 0);
    }

    public function test_tidak_bisa_follow_diri_sendiri(): void
    {
        $me = User::factory()->create();

        $this->actingAs($me)
            ->postJson(route('follow.toggle', $me))
            ->assertStatus(422);

        $this->assertDatabaseCount('follows', 0);
    }

    public function test_follow_dua_kali_tidak_membuat_baris_ganda(): void
    {
        $me     = User::factory()->create();
        $target = User::factory()->create();

        $me->following()->syncWithoutDetaching([$target->id]);
        $me->following()->syncWithoutDetaching([$target->id]);

        $this->assertDatabaseCount('follows', 1);
    }

    public function test_relasi_followers_dan_following_konsisten(): void
    {
        $a = User::factory()->create();
        $b = User::factory()->create();

        $a->following()->attach($b->id);

        $this->assertTrue($a->isFollowing($b));
        $this->assertFalse($b->isFollowing($a));
        $this->assertSame(1, $b->followers()->count());
        $this->assertSame(0, $a->followers()->count());
    }

    public function test_halaman_followers_dan_following_bisa_dibuka(): void
    {
        $a = User::factory()->create(['username' => 'user_satu']);
        $b = User::factory()->create(['name' => 'Budi Pengikut']);

        $b->following()->attach($a->id);

        $this->get(route('profile.followers', $a->username))
            ->assertStatus(200)
            ->assertSee('Budi Pengikut');

        $this->get(route('profile.following', $b->route_handle))
            ->assertStatus(200)
            ->assertSee($a->name);
    }
}
