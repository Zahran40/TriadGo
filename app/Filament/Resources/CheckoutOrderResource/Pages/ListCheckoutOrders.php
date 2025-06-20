<?php

namespace App\Filament\Resources\CheckoutOrderResource\Pages;

use App\Filament\Resources\CheckoutOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCheckoutOrders extends ListRecords
{
    protected static string $resource = CheckoutOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
