<?php
namespace App\Filament\Resources\DiscussionResource\Pages;

use App\Filament\Resources\DiscussionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDiscussion extends CreateRecord
{
    protected static string $resource = DiscussionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Admin yang buat diskusi manual dianggap sebagai user_id = current admin
        $data['user_id'] = auth()->id();
        return $data;
    }
}
