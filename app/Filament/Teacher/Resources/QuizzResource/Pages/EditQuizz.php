<?php

namespace App\Filament\Teacher\Resources\QuizzResource\Pages;

use App\Filament\Teacher\Resources\QuizzResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuizz extends EditRecord
{
    protected static string $resource = QuizzResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
