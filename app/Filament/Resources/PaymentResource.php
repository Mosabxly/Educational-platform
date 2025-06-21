<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
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

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

  protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'سجل المدفوعات';
    protected static ?string $pluralModelLabel = 'سجل المدفوعات';
    protected static ?string $modelLabel = "عملية دفع";
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

                Select::make('enrollment_id')
                    ->label('رقم التسجيل')
                    ->relationship('enrollment', 'id')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('payment_status')
                    ->options([
                        'pending' => 'معلقة',
                        'paid' => 'مدفوعة',
                        'free' => 'مجانية',
                    ])
                    ->label('حالة الدفع')
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

                TextColumn::make('enrollment.id')
                    ->label('رقم التسجيل')
                    ->searchable(),

                TextColumn::make('payment_status')
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
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
