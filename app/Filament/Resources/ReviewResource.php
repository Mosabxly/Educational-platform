<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Filament\Resources\ReviewResource\RelationManagers;
use App\Models\Review;
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
class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'التقييمات';
    protected static ?string $pluralModelLabel = 'التقييمات';
    protected static ?string $modelLabel = "تقييم";
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

                Select::make('course_id')
                    ->label('الدورة')
                    ->relationship('course', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('rating')
                    ->label( 'التقييم')
                    ->nullable()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(5),

                TextInput::make('comment')
                    ->label('تعليق/ملاحظة')
                    ->nullable(),
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

                TextColumn::make('course.title')
                    ->label('الدورة')
                    ->searchable(),

                TextColumn::make('rating')
                    ->label('التقييم')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('comment')
                    ->label('تعليق/ملاحظة'),
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
           // RelationManagers\CourseRelationManager::class
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
