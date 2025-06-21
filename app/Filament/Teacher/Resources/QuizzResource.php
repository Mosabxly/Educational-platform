<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\QuizzResource\Pages;
use App\Filament\Teacher\Resources\QuizzResource\RelationManagers;
use App\Models\Quizz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizzResource extends Resource
{
    protected static ?string $model = Quizz::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuizzs::route('/'),
            'create' => Pages\CreateQuizz::route('/create'),
            'edit' => Pages\EditQuizz::route('/{record}/edit'),
        ];
    }
}
