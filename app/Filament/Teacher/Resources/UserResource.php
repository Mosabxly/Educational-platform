<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\UserResource\Pages;
use App\Filament\Teacher\Resources\UserResource\RelationManagers;
use App\Models\User;
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
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Filters\SelectFilter;

use App\Filament\Instructor\Resources\UserResource\Pages\ListUsers;
class UserResource extends Resource
{
    protected static ?string $model = User::class;


    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'المستخدمين';
    protected static ?string $pluralModelLabel = 'المستخدمين';


    protected static ?string $modelLabel = "مستخدم"; 
    
   public static function getEloquentQuery(): Builder
{
    $teacherId = auth()->id();

    return parent::getEloquentQuery()
        ->where('role', 'student')
        ->whereExists(function ($query) use ($teacherId) {
            $query->selectRaw(1)
                ->from('enrollments')
                ->join('courses', 'enrollments.course_id', '=', 'courses.id')
                ->whereColumn('enrollments.student_id', 'users.id')
                ->where('courses.instructor_id', $teacherId);
        });
}
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
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('الاسم'),
                    
                TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->label('البريد الإلكتروني'),
                    
                TextColumn::make('role')
                    ->sortable()
                    ->searchable()
                    ->label('الدور'),

            ])
            ->filters([
                //
            ])
            ->actions([
             //
            ])
            ->bulkActions([
            
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CertificatesRelationManager::class,
            RelationManagers\EnrollmentsRelationManager::class,
           // RelationManagers\QuizResultsRelationManager::class,
            RelationManagers\ReviewsRelationManager::class,
            
        ];
    }

    public static function getPages(): array
    {
        return [
              'index' => Pages\ListUsers::route('/'),
           /* 'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),*/
        ];
    }
}
