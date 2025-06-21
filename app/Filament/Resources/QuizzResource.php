<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizzResource\Pages;
use App\Filament\Resources\QuizzResource\RelationManagers;
use App\Models\Quiz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class QuizzResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationLabel = 'الاختبارات';
    protected static ?string $pluralModelLabel = 'الاختبارات';
    protected static ?string $modelLabel = "اختبار";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('course_id')
                    ->label('الدورة')
                    ->relationship('course', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('title')
                    ->label('نوع الاختبار')
                    ->required(),
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('course.title')
                    ->label('الدورة')
                    ->searchable(),

                TextColumn::make('title')
                    ->label('نوع الاختبار')
                    ->searchable()
                    ->sortable(),
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            //RelationManagers\ResultsRelationManager::class
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