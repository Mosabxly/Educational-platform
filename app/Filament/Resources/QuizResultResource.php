<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizResultResource\Pages;
use App\Models\QuizResult;
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

use App\Filament\Resources\QuizResultResource\RelationManagers;

class QuizResultResource extends Resource
{
    protected static ?string $model = QuizResult::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'نتائج الاختبارت';
    protected static ?string $pluralModelLabel = 'نتائج الاختبارت';
    protected static ?string $modelLabel = "نتيجة";

    public static function form(Form $form): Form
    {
          return $form
            ->schema([
                Select::make('student_id')
                    ->label('الطالب')
                    ->relationship(
                        'student', 
                        'name', 
                        fn($query) => $query->where('role', 'student')
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('quiz_id')
                    ->label('الاختبار')
                    ->relationship('quiz', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('score')
                    ->label('الدرجة')
                    ->required()
                    ->numeric(),
                //
            ]);
    }

    public static function table(Table $table): Table
    {
       return $table
            ->columns([
                TextColumn::make('student.name')
                    ->label('الطالب')
                    ->searchable(),

                TextColumn::make('quiz.title')
                    ->label('نوع الاختبار')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('score')
                    ->label('الدرجة'),
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
          // RelationManagers\QuizRelationManager::class  
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
