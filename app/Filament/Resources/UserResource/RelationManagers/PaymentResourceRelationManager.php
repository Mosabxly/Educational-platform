<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResourceRelationManager extends RelationManager
{
    protected static string $relationship = 'PaymentResource';

    public function form(Form $form): Form
    {
         return $form
            ->schema([
                Forms\Components\Select::make('payment_status')
                    ->options([
                        'pending' => 'معلقة',
                        'paid' => 'مدفوعة',
                        'free' => 'مجانية',
                    ])
                    ->label('حالة الدفع')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
       return $table
            ->recordTitleAttribute('payment_status')
            ->columns([
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('حالة الدفع')
                    ->searchable()
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'free' => 'gray',
                    }),
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
