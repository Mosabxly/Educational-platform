<?php

namespace App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EnrollmentResourceRelationManager extends RelationManager
{
    protected static string $relationship = 'EnrollmentResource';

    public function form(Form $form): Form
    {
        return $form
             ->schema([
            Forms\Components\Select::make('student_id')
                ->label('اختر الطالب')
                ->options(
                    \App\Models\User::where('role', 'student')->pluck('name', 'id')
                )
                ->searchable()
                ->required(),

            Forms\Components\Select::make('instructor_id')
                ->label('اختر الأستاذ')
                ->options(
                    \App\Models\User::where('role', 'instructor')->pluck('name', 'id')
                )
                ->searchable()
                ->required(),

            Forms\Components\DateTimePicker::make('enrolled_at')
                ->label('تاريخ التسجيل')
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.name')->label('اسم الطالب'),
                Tables\Columns\TextColumn::make('enrolled_at')->label('تاريخ التسجيل')->dateTime(),
                    Tables\Columns\TextColumn::make('instructor.name')->label('اسم الأستاذ'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
