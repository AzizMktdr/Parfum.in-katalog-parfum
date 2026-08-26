<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note;

class NoteImageSeeder extends Seeder
{
    public function run(): void
    {
        $notes    = Note::all();
        $updated  = 0;
        $missing  = [];

        foreach ($notes as $note) {
            // Cari file di public/images/notes/ dengan ekstensi png/jpg/jpeg/webp
            $extensions = ['png', 'jpg', 'jpeg', 'webp'];
            $found = null;

            foreach ($extensions as $ext) {
                $path = "images/notes/{$note->slug}.{$ext}";
                if (file_exists(public_path($path))) {
                    $found = $path;
                    break;
                }
            }

            if ($found) {
                $note->update(['image_path' => $found]);
                $updated++;
                $this->command->line("  ✅ {$note->name} → {$found}");
            } else {
                $missing[] = $note->slug;
            }
        }

        $this->command->info("\n✅ Updated: {$updated} notes");

        if (!empty($missing)) {
            $this->command->warn('⚠️  File gambar belum ada (' . count($missing) . '):');
            foreach ($missing as $slug) {
                $this->command->line("   public/images/notes/{$slug}.png");
            }
            $this->command->line('');
            $this->command->line('Taruh file gambar di public/images/notes/');
            $this->command->line('Nama file harus sama dengan slug note.');
            $this->command->line('Jalankan seeder ini lagi setelah gambar ditambahkan.');
        }
    }
}
