<?php
namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, string $slug)
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'require_login' => true, 'message' => 'Login untuk menulis review.'], 401);
            }
            return redirect()->route('login')->with('error', 'Login untuk menulis review.');
        }

        $request->validate([
            'sillage'    => 'required|integer|between:1,5',
            'projection' => 'required|integer|between:1,5',
            'longevity'  => 'required|integer|between:1,5',
            'body'       => 'required|string|min:10|max:1000',
        ]);

        $existing = Review::where('user_id', Auth::id())
                          ->where('product_slug', $slug)->first();

        if ($existing) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Anda sudah memberikan review untuk parfum ini.'], 422);
            }
            return back()->with('error', 'Anda sudah memberikan review untuk parfum ini.');
        }

        $review = Review::create([
            'user_id'      => Auth::id(),
            'product_slug' => $slug,
            'sillage'      => $request->sillage,
            'projection'   => $request->projection,
            'longevity'    => $request->longevity,
            'review_text'  => $request->body,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Review berhasil dikirim! Terima kasih.',
                'review'  => [
                    'author'     => Auth::user()->name,
                    'sillage'    => $review->sillage,
                    'projection' => $review->projection,
                    'longevity'  => $review->longevity,
                    'text'       => $review->review_text,
                    'date'       => $review->created_at->format('d F Y'),
                    'rating'     => round(($review->sillage + $review->projection + $review->longevity) / 3, 1),
                ],
            ]);
        }

        return back()->with('success', 'Review berhasil dikirim! Terima kasih.');
    }

    public function index(string $slug)
    {
        // ✅ EAGER LOADING: muat relasi user sekaligus agar tidak N+1 per review
        $reviews = Review::with('user:id,name')
            ->where('product_slug', $slug)
            ->latest()
            ->get()
            ->map(fn($r) => [
                'user_id'    => $r->user_id,
                'author'     => $r->user?->name ?? 'Anonymous',
                'sillage'    => $r->sillage,
                'projection' => $r->projection,
                'longevity'  => $r->longevity,
                'text'       => $r->review_text,
                'date'       => $r->created_at->format('d F Y'),
                'rating'     => round(($r->sillage + $r->projection + $r->longevity) / 3, 1),
            ]);

        return response()->json(['reviews' => $reviews]);
    }
}
