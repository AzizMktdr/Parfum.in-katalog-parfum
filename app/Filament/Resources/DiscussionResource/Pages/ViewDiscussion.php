<?php
namespace App\Filament\Resources\DiscussionResource\Pages;

use App\Filament\Resources\DiscussionResource;
use App\Models\DiscussionReply;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewDiscussion extends ViewRecord
{
    protected static string $resource = DiscussionResource::class;
    protected static string $view = 'filament.resources.discussion-resource.pages.view-discussion';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make()
                ->label('Hapus Diskusi'),
        ];
    }

    public function getAllReplies()
    {
        return $this->record
            ->allReplies()
            ->with('user')
            ->latest()
            ->get();
    }

    public function deleteReply(int $replyId): void
    {
        $reply = DiscussionReply::find($replyId);

        if ($reply) {
            $discussion = $this->record;
            $reply->delete();

            // Update counter replies di discussion
            $discussion->decrement('replies_count');

            Notification::make()
                ->title('Balasan dihapus')
                ->success()
                ->send();
        }

        $this->record->refresh();
    }
}
