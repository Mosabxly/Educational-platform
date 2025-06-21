<?php

namespace App\Filament\Teacher\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CertificatesRelationManager extends RelationManager
{
    protected static string $relationship = 'Certificates';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('certificate_url')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {   return $table
            ->recordTitleAttribute('certificate_url')
            ->columns([
                Tables\Columns\TextColumn::make('certificate_url')
                    ->label('الشهادة'),
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
