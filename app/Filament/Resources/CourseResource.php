<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Group;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Filters\FilterGroup;
use Filament\Tables\Enums\FiltersLayout;
class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'الدورات';
    protected static ?string $pluralModelLabel = 'الدورات';
    protected static ?string $modelLabel = "دورة";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('الدورة')
                    ->required(),

                Textarea::make('description')
                    ->label('الوصف')
                    ->nullable(),

                Select::make('level')
                    ->options([
                        'beginner' => 'مبتدئ',
                        'intermediate' => 'متوسط',
                        'advanced' => 'متقدم',
                    ])
                    ->label('المستوى')
                    ->required()
                    ->placeholder('اختر المستوى'),

                Group::make()
                    ->schema([
                        DateTimePicker::make('start_at')
                            ->label('تاريخ البدء')
                            ->required(),

                        DateTimePicker::make('end_at')
                            ->label('تاريخ الانتهاء')
                            ->required(),
                    ])
                    ->columns(2),
                /*DateTimePicker::make('start_at')
                ->label('تاريخ البدء')
                ->required(),

                DateTimePicker::make('end_at')
                ->label('تاريخ الانتهاء')
                ->required(),*/

                /*Section::make('موعد الدورة')
                    ->schema([
                        DateTimePicker::make('start_at')
                            ->label('تاريخ البدء')
                            ->required(),

                        DateTimePicker::make('end_at')
                            ->label('تاريخ الانتهاء')
                            ->required(),
                    ])
                    ->columns(2) 
                    ->collapsible(),*/

                TextInput::make('address')
                ->label('العنوان')
                ->nullable(),

                
                Select::make('course_status')
                    ->options([
                        'paid' => 'مدفوعة',
                        'free' => 'مجانية',
                    ])
                    ->label('حالة الدورة')
                    ->required(),

                TextInput::make('price')
                    ->label('السعر')
                    ->nullable()
                    ->numeric(),

                Select::make('category_id')
                    ->label('التصنيف')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('instructor_id')
                    ->label('المدرب')
                    ->relationship(
                        'instructor', 
                        'name', 
                        fn($query) => $query->where('role', 'instructor')
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('الدورة')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->label('الوصف'),

                TextColumn::make('level')
                    ->label('المستوى')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('start_at')
                    ->label('تاريخ البدء')
                    ->dateTime(),

                TextColumn::make('end_at')
                    ->label('تاريخ الانتهاء')
                    ->dateTime(),

                TextColumn::make('address')
                    ->label('العنوان')
                    ->searchable(),

                TextColumn::make('course_status')
                    ->label('حالة الدورة')
                    ->searchable(),

                TextColumn::make('price')
                    ->label('السعر')
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('التصنيف')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('instructor.name')
                    ->label('المدرب')
                    ->searchable(),

                //
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('التصنيف')
                    ->relationship('category', 'name'),

                SelectFilter::make('level')
                    ->label('المستوى')
                    //->multiple()
                    ->options([
                        'beginner' => 'مبتدئ',
                        'intermediate' => 'متوسط',
                        'advanced' => 'متقدم',
                    ]),

                SelectFilter::make('course_status')
                    ->label('حالة الدورة')
                    ->options([
                        'paid' => 'مدفوعة',
                        'free' => 'مجانية',
                    ]),
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
           
            RelationManagers\LessonsRelationManager::class,
            RelationManagers\CertificateRelationManager::class,
            RelationManagers\EnrollmentsRelationManager::class,
            RelationManagers\PaymentsRelationManager::class,
            RelationManagers\QuizzesRelationManager::class,
            RelationManagers\ReviewsRelationManager::class
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}


