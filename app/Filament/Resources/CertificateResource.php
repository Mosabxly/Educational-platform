<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateResource\Pages;
use App\Filament\Resources\CertificateResource\RelationManagers;
use App\Models\Certificate;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\FileColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;


class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;


    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'الشهائد';
    protected static ?string $pluralModelLabel = 'الشهائد';
    protected static ?string $modelLabel = "شهادة";

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

                FileUpload::make('certificate_url')
                    ->label('الشهادة')
                    ->image()
                    //->acceptedFileTypes(['application/pdf'])    //For PDF Files
                    //->acceptedFileTypes(['image/*', 'application/pdf'])    //For PDF & Image Files
                    ->directory('certificates')
                    ->disk('public')
                    ->imageEditor() 
                    ->openable()
                    ->downloadable()
                    ->required(),   
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

                ImageColumn::make('certificate_url')
                    ->label('الشهادة')
                    ->disk('public'),
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                  Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                //هذه الأفعال التي يمكن تطبيقها على كل صف
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    //هذه أفعال يمكن تنفيذها على عدة صفوف مرة واحدة
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
           
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCertificates::route('/'),
            'create' => Pages\CreateCertificate::route('/create'),
            'edit' => Pages\EditCertificate::route('/{record}/edit'),
        ];
    }
}
