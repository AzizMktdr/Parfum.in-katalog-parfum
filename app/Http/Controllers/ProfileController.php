<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /** Profil publik: /u/{username} */
    public function show(string $username)
    {
        $user = User::findByHandleOrFail($username);

        // Eager loading: items + product dimuat sekaligus, bukan N+1
        $collections = $user->collections()
            ->where('is_public', true)
            ->withCount(['items', 'likes'])
            ->with(['items' => fn ($q) => $q->with('product')->limit(3)])
            ->latest()
            ->get()
            ->map(function ($col) {
                $col->previews = $col->items
                    ->map(fn ($item) => $item->product?->image_url)
                    ->filter()
                    ->values();

                return $col;
            });

        $recentReviews = $user->reviews()
            ->with('product')
            ->latest()
            ->limit(4)
            ->get();

        $stats = [
            'favorites'   => $user->favorites()->count(),
            'reviews'     => $user->reviews()->count(),
            'collections' => $user->collections()->where('is_public', true)->count(),
            'followers'   => $user->followers()->count(),
            'following'   => $user->following()->count(),
        ];

        $isFollowing = Auth::check() && Auth::user()->isFollowing($user);
        $isOwner     = Auth::id() === $user->id;

        return view('profile.show', compact(
            'user', 'collections', 'recentReviews', 'stats', 'isFollowing', 'isOwner'
        ));
    }

    /** Halaman pengaturan akun (hanya pemilik). */
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    /** Simpan perubahan profil. */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'username' => ['nullable', 'string', 'min:3', 'max:30', 'alpha_dash', Rule::unique('users', 'username')->ignore($user->id)],
            'bio'      => ['nullable', 'string', 'max:200'],
            'avatar'   => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ], [
            'name.required'       => 'Nama wajib diisi.',
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Format email tidak valid.',
            'email.unique'        => 'Email sudah dipakai akun lain.',
            'username.unique'     => 'Username sudah dipakai.',
            'username.alpha_dash' => 'Username hanya boleh huruf, angka, dash, dan underscore.',
            'username.min'        => 'Username minimal 3 karakter.',
            'avatar.image'        => 'File avatar harus berupa gambar.',
            'avatar.mimes'        => 'Avatar harus berformat JPG, PNG, atau WEBP.',
            'avatar.max'          => 'Ukuran avatar maksimal 2 MB.',
        ]);

        $data = ['name' => $validated['name']];

        // Ganti email → status verifikasi direset.
        if ($validated['email'] !== $user->email) {
            $data['email']             = $validated['email'];
            $data['email_verified_at'] = null;
        }

        // Field opsional hanya disentuh kalau memang dikirim oleh form.
        if ($request->has('username')) {
            $data['username'] = $validated['username'] ?: null;
        }

        if ($request->has('bio')) {
            $data['bio'] = $validated['bio'] ?: null;
        }

        if ($request->hasFile('avatar')) {
            $this->deleteAvatar($user);
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } elseif ($request->boolean('remove_avatar')) {
            $this->deleteAvatar($user);
            $data['avatar'] = null;
        }

        $user->forceFill($data)->save();

        return redirect()->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /** Ganti password (butuh konfirmasi password lama). */
    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required'         => 'Password baru wajib diisi.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
        ]);

        if (! Hash::check($validated['current_password'], $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Password saat ini salah.'])
                ->onlyInput('email');
        }

        $user->forceFill(['password' => $validated['password']])->save();

        return redirect()->route('profile.edit')
            ->with('success', 'Password berhasil diganti.');
    }

    private function deleteAvatar(User $user): void
    {
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }
    }
}
