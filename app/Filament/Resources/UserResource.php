<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
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

use App\Filament\Resources\ReviewsRelationRelationManager;
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'المستخدمين';
    protected static ?string $pluralModelLabel = 'المستخدمين';
    protected static ?string $modelLabel = "مستخدم";


    public static function form(Form $form): Form
    {
     return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('الاسم'),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique()
                    ->label('البريد الإلكتروني'),

                TextInput::make('password')
                    ->password()
                    ->required()
                    ->label('كلمة المرور'),

                Select::make('role')
                    ->options([
                        'admin' => 'مسؤول',
                        'student' => 'طالب',
                        'instructor' => 'مدرب',
                    ])
                    ->required()
                    ->label('الدور')
                    ->placeholder('اختر الدور'),

                TextInput::make('major')
                    ->nullable()
                    ->label('major(optional)')
                    ->label('التخصص'),

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
                    
                TextColumn::make('major')
                    ->sortable()
                    ->searchable()
                    ->label('التخصص'),
                //
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'admin' => 'مسؤول',
                        'student' => 'طالب',
                        'instructor' => 'مدرب',
                    ])
                    ->label('الدور'),
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
          

           // RelationManagers\CourseResourceRelationManager::class,            
             RelationManagers\EnrollmentResourceRelationManager::class,
            RelationManagers\ReviewsRelationRelationManager::class,
            RelationManagers\QuizResultResourceRelationManager::class,
            RelationManagers\PaymentResourceRelationManager::class,
            RelationManagers\CertificateResourceRelationManager::class
            
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
