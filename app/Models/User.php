<?php
namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER  = 'user';

    protected $fillable = [
        'name', 'username', 'email', 'password', 'avatar', 'bio', 'role',
    ];

    protected $hidden = ['password', 'remember_token'];

    /**
     * Role default selalu "user".
     * Mencegah user biasa mengangkat dirinya jadi admin lewat form register.
     */
    protected $attributes = [
        'role' => self::ROLE_USER,
    ];

    protected function casts(): array
    {
        return [
            'password'          => 'hashed',
            'email_verified_at' => 'datetime',
        ];
    }

    /* ───────────────────────── Relasi ───────────────────────── */

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function collections(): HasMany
    {
        return $this->hasMany(Collection::class);
    }

    public function discussions(): HasMany
    {
        return $this->hasMany(Discussion::class);
    }

    public function discussionReplies(): HasMany
    {
        return $this->hasMany(DiscussionReply::class);
    }

    /** User-user yang diikuti oleh user ini. */
    public function following(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id')
            ->withTimestamps();
    }

    /** User-user yang mengikuti user ini. */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id')
            ->withTimestamps();
    }

    /* ───────────────────────── Helper ───────────────────────── */

    public function isFollowing(?User $user): bool
    {
        if (! $user || ! $user->exists) {
            return false;
        }

        return $this->following()->where('users.id', $user->getKey())->exists();
    }

    public function hasFavorited(string $slug): bool
    {
        return $this->favorites()->where('product_slug', $slug)->exists();
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }

    /* ───────────────────────── Accessor ───────────────────────── */

    /**
     * URL avatar siap pakai, atau null kalau user belum upload.
     * Butuh `php artisan storage:link` agar file di storage bisa diakses.
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if (blank($this->avatar)) {
            return null;
        }

        if (Str::startsWith($this->avatar, ['http://', 'https://'])) {
            return $this->avatar;
        }

        return asset('storage/' . ltrim($this->avatar, '/'));
    }

    /** Huruf pertama nama, untuk avatar fallback. */
    public function getInitialAttribute(): string
    {
        $name = trim((string) $this->name);

        return $name === '' ? '?' : Str::upper(Str::substr($name, 0, 1));
    }

    /** Alias lama yang masih dipakai beberapa view. */
    public function getAvatarLetterAttribute(): string
    {
        return $this->initial;
    }

    /**
     * Cari user dari potongan URL profil publik: username kalau ada,
     * kalau tidak ID numerik.
     */
    public static function findByHandleOrFail(string $handle): self
    {
        return static::query()
            ->where('username', $handle)
            ->when(ctype_digit($handle), fn ($q) => $q->orWhere('id', (int) $handle))
            ->firstOrFail();
    }

    /** Identifier yang dipakai di URL profil publik. */
    public function getRouteHandleAttribute(): string
    {
        return (string) ($this->username ?: $this->id);
    }

    public function getProfileUrlAttribute(): string
    {
        return route('profile.show', $this->route_handle);
    }
}
