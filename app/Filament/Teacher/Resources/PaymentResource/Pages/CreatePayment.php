<?php

namespace App\Filament\Teacher\Resources\PaymentResource\Pages;

use App\Filament\Teacher\Resources\PaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;
}
