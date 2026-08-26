<?php
namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Collection;
use App\Models\DiscussionLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CommunityController extends Controller
{
    public function feed(Request $request)
    {
        $tab  = $request->query('tab', 'discussions');
        $page = $request->query('page', 1);

        $discussions = collect();
        $collections = collect();
        $likedIds    = [];

        if ($tab === 'discussions') {
            // ✅ EAGER LOADING: user + previewReplies + replies.user dimuat sekaligus
            $discussions = Discussion::with([
                'user:id,name,username,avatar',
                'previewReplies' => fn($q) => $q
                    ->with('user:id,name,username,avatar')
                    ->whereNull('parent_id')
                    ->latest()
                    ->limit(4),
            ])->latest()->paginate(15);

            // ✅ CHUNKING: cek liked IDs dalam 1 query WHERE IN
            //    bukan N query satu per diskusi
            if (Auth::check()) {
                $likedIds = DiscussionLike::where('user_id', Auth::id())
                    ->whereIn('discussion_id', $discussions->pluck('id'))
                    ->pluck('discussion_id')
                    ->toArray();
            }
        }

        if ($tab === 'collections') {
            // ✅ EAGER LOADING: user + items.product dimuat sekaligus
            // Cache 5 menit untuk guest (tidak ada data personal)
            $cacheKey = "community.collections.page.{$page}";

            if (!Auth::check()) {
                $collections = Cache::remember($cacheKey, 300, fn() =>
                    Collection::where('is_public', true)
                        ->with([
                            'user:id,name,username,avatar',
                            'items' => fn($q) => $q->with('product:slug,name,image')->limit(3),
                        ])
                        ->withCount(['items', 'likes'])
                        ->latest()
                        ->paginate(12)
                );
            } else {
                $collections = Collection::where('is_public', true)
                    ->with([
                        'user:id,name,username,avatar',
                        'items' => fn($q) => $q->with('product:slug,name,image')->limit(3),
                    ])
                    ->withCount(['items', 'likes'])
                    ->latest()
                    ->paginate(12);
            }
        }

        return view('community.feed', compact('discussions', 'collections', 'tab', 'likedIds'));
    }
}
