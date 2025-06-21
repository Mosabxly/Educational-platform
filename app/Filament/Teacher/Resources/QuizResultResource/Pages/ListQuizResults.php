<?php

namespace App\Filament\Teacher\Resources\QuizResultResource\Pages;

use App\Filament\Teacher\Resources\QuizResultResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuizResults extends ListRecords
{
    protected static string $resource = QuizResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
