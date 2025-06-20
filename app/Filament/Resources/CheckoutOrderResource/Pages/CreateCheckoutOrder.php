<?php

namespace App\Filament\Resources\CheckoutOrderResource\Pages;

use App\Filament\Resources\CheckoutOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCheckoutOrder extends CreateRecord
{
    protected static string $resource = CheckoutOrderResource::class;
}
