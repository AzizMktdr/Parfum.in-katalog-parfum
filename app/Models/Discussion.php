<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'body', 'likes_count', 'replies_count'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Semua top-level replies (untuk halaman detail)
    public function replies()
    {
        return $this->hasMany(DiscussionReply::class)
                    ->whereNull('parent_id')
                    ->latest();
    }

    // Max 4 replies untuk preview di feed
    public function previewReplies()
    {
        return $this->hasMany(DiscussionReply::class)
                    ->whereNull('parent_id')
                    ->latest()
                    ->limit(4);
    }

    public function allReplies()
    {
        return $this->hasMany(DiscussionReply::class);
    }

    public function likes()
    {
        return $this->hasMany(DiscussionLike::class);
    }

    public function isLikedBy(?User $user): bool
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
