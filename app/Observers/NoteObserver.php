<?php
namespace App\Observers;

use App\Models\Note;
use App\Services\ImageResizeService;
use Illuminate\Support\Facades\Cache;

class NoteObserver
{
    public function saved(Note $note): void
    {
        Cache::forget('notes.index');  // key yang dipakai NoteController

        if (!$note->image_path) return;
        if (!$note->wasChanged('image_path') && !$note->wasRecentlyCreated) return;

        $imagePath = $note->image_path;
        dispatch(function () use ($imagePath) {
            ImageResizeService::resizeAndCrop($imagePath, 200, 200);
        })->afterResponse();
    }

    public function deleted(Note $note): void
    {
        Cache::forget('notes.index');
    }
}
