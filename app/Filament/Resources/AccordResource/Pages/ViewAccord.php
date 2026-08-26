<?php

namespace App\Filament\Resources\AccordResource\Pages;

use App\Filament\Resources\AccordResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAccord extends ViewRecord
{
    protected static string $resource = AccordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
