<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnrollmentResource\Pages;
use App\Filament\Resources\EnrollmentResource\RelationManagers;
use App\Models\Enrollment;
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
use Filament\Forms\Components\DateTimePicker;


class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'التسجيل في الدورات';
    protected static ?string $pluralModelLabel = 'التسجيل في الدورات';
    protected static ?string $modelLabel = "تسجيل";

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

                DateTimePicker::make('enrolled_at')
                    ->label('تاريخ التسجيل')
                    ->required(),

                Select::make('retreat')
                    ->options([
                        true => 'نعم',
                        false => 'لا',
                    ])
                    ->label('الانسحاب')
                    ->required()
                    ->native(false)
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

                TextColumn::make('enrolled_at')
                    ->label('تاريخ التسجيل')
                    ->dateTime()
                    ->searchable(),

                TextColumn::make('retreat')
                    ->label('الانسحاب')
                    ->formatStateUsing(fn ($state) => $state ? 'نعم' : 'لا')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnrollments::route('/'),
            'create' => Pages\CreateEnrollment::route('/create'),
            'edit' => Pages\EditEnrollment::route('/{record}/edit'),
        ];
    }
}
