<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseResourceRelationManager extends RelationManager
{
    protected static string $relationship = 'CourseResource';

    public function form(Form $form): Form
    {
         return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('السعر')
                    ->nullable(),
            ]);
    }

    public function table(Table $table): Table
    {
          return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('كورس')
                    ->label('اسم الدورة'),

                Tables\Columns\TextColumn::make('السعر')
                    ->label('السعر'),
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
