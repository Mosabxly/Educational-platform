<?php

namespace App\Filament\Resources\QuizzResource\Pages;

use App\Filament\Resources\QuizzResource;
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
