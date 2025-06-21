<?php

namespace App\Filament\Teacher\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LessonsRelationManager extends RelationManager
{
    protected static string $relationship = 'Lessons';
protected static ?string $recordTitleAttribute = 'الدوره';
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                 ->label('عنوان الدرس')    
                ->required()
                    ->maxLength(255), //نموذج إنشاء أو تعديل الدرس:

                    Forms\Components\TextInput::make('name')->label('عنوان الدرس'),
Forms\Components\Textarea::make('description')->label('وصف الدرس'),
Forms\Components\FileUpload::make('video')->label('فيديو الدرس')->directory('lessons'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),

                Tables\Columns\TextColumn::make('description')->label('الوصف'),
Tables\Columns\TextColumn::make('created_at')->date()->label('تاريخ الإنشاء'),
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
