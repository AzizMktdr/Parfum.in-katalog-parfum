<?php
namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\DiscussionLike;
use App\Models\DiscussionReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Semua aksi tulis di controller ini sudah dilindungi middleware `auth`
 * dan `throttle` di routes/web.php.
 */
class DiscussionController extends Controller
{
    /** Detail diskusi + semua balasan. */
    public function show(Discussion $discussion)
    {
        $discussion->load([
            'user:id,name,username,avatar',
            'replies.user:id,name,username,avatar',
            'replies.children.user:id,name,username,avatar',
        ]);

        $isLiked = $discussion->isLikedBy(Auth::user());

        return view('community.discussion', compact('discussion', 'isLiked'));
    }

    /** Buat diskusi baru. */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'body'  => ['required', 'string', 'max:5000'],
        ], [
            'title.required' => 'Judul diskusi wajib diisi.',
            'body.required'  => 'Isi diskusi wajib diisi.',
        ]);

        Discussion::create([
            'user_id' => Auth::id(),
            'title'   => $validated['title'],
            'body'    => $validated['body'],
        ]);

        return redirect()->route('community', ['tab' => 'discussions'])
            ->with('success', 'Diskusi berhasil dibuat!');
    }

    /** Tambah balasan. */
    public function reply(Request $request, Discussion $discussion)
    {
        $validated = $request->validate([
            'body'      => ['required', 'string', 'max:2000'],
            // Balasan bertingkat hanya boleh menunjuk balasan di diskusi yang sama.
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('discussion_replies', 'id')->where('discussion_id', $discussion->id),
            ],
        ], [
            'body.required' => 'Isi balasan wajib diisi.',
        ]);

        DB::transaction(function () use ($validated, $discussion) {
            DiscussionReply::create([
                'discussion_id' => $discussion->id,
                'user_id'       => Auth::id(),
                'parent_id'     => $validated['parent_id'] ?? null,
                'body'          => $validated['body'],
            ]);

            $this->syncReplyCount($discussion);
        });

        return $this->backToSource($request, $discussion, 'Balasan ditambahkan!');
    }

    /** Like / unlike (AJAX). */
    public function like(Request $request, Discussion $discussion)
    {
        $liked = DB::transaction(function () use ($discussion) {
            $existing = DiscussionLike::where('user_id', Auth::id())
                ->where('discussion_id', $discussion->id)
                ->first();

            if ($existing) {
                $existing->delete();
                $liked = false;
            } else {
                DiscussionLike::firstOrCreate([
                    'user_id'       => Auth::id(),
                    'discussion_id' => $discussion->id,
                ]);
                $liked = true;
            }

            $this->syncLikeCount($discussion);

            return $liked;
        });

        if ($request->expectsJson()) {
            return response()->json([
                'liked' => $liked,
                'count' => $discussion->likes_count,
            ]);
        }

        return back();
    }

    /** Hapus diskusi (hanya pemilik). */
    public function destroy(Discussion $discussion)
    {
        abort_unless($discussion->user_id === Auth::id(), 403);

        $discussion->delete(); // balasan & like ikut terhapus lewat cascade FK

        return redirect()->route('community', ['tab' => 'discussions'])
            ->with('success', 'Diskusi dihapus.');
    }

    /** Hapus balasan (hanya pemilik). */
    public function destroyReply(DiscussionReply $reply)
    {
        abort_unless($reply->user_id === Auth::id(), 403);

        $discussion = $reply->discussion;

        DB::transaction(function () use ($reply, $discussion) {
            $reply->delete(); // balasan anak ikut terhapus lewat cascade FK

            if ($discussion) {
                $this->syncReplyCount($discussion);
            }
        });

        return back()->with('success', 'Balasan dihapus.');
    }

    /* ───────────────────────────── Helper ───────────────────────────── */

    /**
     * Hitung ulang counter dari data sebenarnya.
     * Lebih aman daripada increment/decrement yang bisa melenceng
     * kalau ada penghapusan bertingkat atau request gagal di tengah jalan.
     */
    private function syncReplyCount(Discussion $discussion): void
    {
        $discussion->forceFill([
            'replies_count' => $discussion->allReplies()->count(),
        ])->save();
    }

    private function syncLikeCount(Discussion $discussion): void
    {
        $discussion->forceFill([
            'likes_count' => $discussion->likes()->count(),
        ])->save();
    }

    /**
     * Kembali ke halaman asal (feed atau detail).
     * Referer hanya dipercaya kalau benar-benar berasal dari domain aplikasi
     * sendiri, supaya tidak bisa dipakai untuk open redirect.
     */
    private function backToSource(Request $request, Discussion $discussion, string $message)
    {
        $referer = (string) $request->headers->get('referer', '');
        $base    = rtrim(url('/'), '/');

        if ($referer !== '' && str_starts_with($referer, $base)) {
            $path = (string) parse_url($referer, PHP_URL_PATH);

            if (str_starts_with($path, '/community')) {
                return redirect()
                    ->to(route('community', ['tab' => 'discussions']) . '#discussion-' . $discussion->id)
                    ->with('success', $message);
            }
        }

        return redirect()->route('discussion.show', $discussion)
            ->with('success', $message);
    }
}
