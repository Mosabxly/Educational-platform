<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\QuizResultResource\Pages;
use App\Filament\Teacher\Resources\QuizResultResource\RelationManagers;
use App\Models\QuizResult;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizResultResource extends Resource
{
    protected static ?string $model = QuizResult::class;

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
            'index' => Pages\ListQuizResults::route('/'),
            'create' => Pages\CreateQuizResult::route('/create'),
            'edit' => Pages\EditQuizResult::route('/{record}/edit'),
        ];
    }
}
