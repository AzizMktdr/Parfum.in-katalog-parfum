<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    /** Follow / unfollow (dilindungi middleware auth + throttle). */
    public function toggle(Request $request, User $user)
    {
        /** @var User $me */
        $me = Auth::user();

        if ($me->id === $user->id) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Tidak bisa follow diri sendiri.'], 422)
                : back()->with('error', 'Tidak bisa follow diri sendiri.');
        }

        if ($me->isFollowing($user)) {
            $me->following()->detach($user->id);
            $following = false;
        } else {
            // syncWithoutDetaching aman terhadap klik ganda / race condition.
            $me->following()->syncWithoutDetaching([$user->id]);
            $following = true;
        }

        $followersCount = $user->followers()->count();

        if ($request->expectsJson()) {
            return response()->json([
                'following'       => $following,
                'followers_count' => $followersCount,
            ]);
        }

        return back()->with('success', $following ? 'Mulai mengikuti.' : 'Berhenti mengikuti.');
    }

    /** Daftar pengikut. */
    public function followers(string $username)
    {
        return $this->renderList($username, 'followers');
    }

    /** Daftar yang diikuti. */
    public function following(string $username)
    {
        return $this->renderList($username, 'following');
    }

    private function renderList(string $username, string $type)
    {
        $user = User::findByHandleOrFail($username);

        $list = $user->{$type}()
            ->select('users.id', 'users.name', 'users.username', 'users.avatar', 'users.bio')
            ->orderByDesc('follows.created_at')
            ->paginate(20);

        return view('profile.followers', compact('user', 'list', 'type'));
    }
}
