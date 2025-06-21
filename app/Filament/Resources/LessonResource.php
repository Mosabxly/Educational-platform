<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonResource\Pages;
use App\Filament\Resources\LessonResource\RelationManagers;
use App\Models\Lesson;
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
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;
use App\Filament\Resources\LessonResource\RelationManagers\CourseRelationManager;
class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

  protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'الدروس';
    protected static ?string $pluralModelLabel = 'الدروس';
    protected static ?string $modelLabel = "درس";
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

                FileUpload::make('content')
                    ->label('الدرس')
                    ->acceptedFileTypes(['video/*']) 
                    ->maxSize(102400) 
                    ->directory('lessons_contents')
                    ->disk('public')
                    ->openable()
                    ->downloadable()
                    ->required(),

                TextInput::make('order')
                    ->label('رقم الدرس')
                    ->required()
                    ->numeric(),
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

                TextColumn::make('content')
                    ->label('الدرس') 
                    ->formatStateUsing(function ($state) {
                        $filename = pathinfo($state, PATHINFO_BASENAME);
                        return $filename . '<br><span">مشاهدة / تحميل</span>';
                    })
                    ->html() 
                    ->url(function ($record) {
                        /** @var \Illuminate\Contracts\Filesystem\Cloud $disk */
                        $disk = \Illuminate\Support\Facades\Storage::disk('public');
                        return $disk->url($record->content);
                    })
                    ->openUrlInNewTab()
                    ->searchable(),

                TextColumn::make('order')
                    ->label('رقم الدرس'),
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
            //RelationManagers\CourseRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}
