<?php

namespace App\Filament\Resources\ConversationMessageResource\Pages;

use App\Filament\Resources\ConversationMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConversationMessage extends EditRecord
{
    protected static string $resource = ConversationMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
