<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use App\Models\CheckoutOrder;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;

class OrderMonitoring extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static string $view = 'filament.pages.order-monitoring';

    protected static ?string $navigationLabel = 'Order Monitoring';

    protected static ?string $title = 'Order Monitoring';

    protected static ?int $navigationSort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(CheckoutOrder::query())
            ->columns([
                Tables\Columns\TextColumn::make('order_id')
                    ->label('Order ID')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Order ID copied to clipboard')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('first_name')
                    ->label('Customer')
                    ->formatStateUsing(fn (CheckoutOrder $record): string => 
                        "{$record->first_name} {$record->last_name}")
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone'),

                Tables\Columns\TextColumn::make('country')
                    ->label('Country')
                    ->searchable()
                    ->badge()
                    ->icon('heroicon-m-map-pin'),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->money('USD')
                    ->sortable()                ->weight('bold')
                ->color('success'),

            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'pending' => 'warning',
                    'paid' => 'success',
                    'failed' => 'danger',
                    'cancelled' => 'gray',
                    default => 'gray',
                })
                    ->icons([
                        'heroicon-m-clock' => 'pending',
                        'heroicon-m-check-circle' => 'paid',
                        'heroicon-m-x-circle' => 'failed',
                        'heroicon-m-minus-circle' => 'cancelled',
                    ]),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn (string $state): string => strtoupper($state)),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Order Date')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('payment_completed_at')
                    ->label('Payment Date')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable()
                    ->placeholder('Not paid yet'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Order Status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'cancelled' => 'Cancelled',
                    ]),

                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Payment Method')
                    ->options([
                        'midtrans' => 'Midtrans',
                        'bank_transfer' => 'Bank Transfer',
                        'credit_card' => 'Credit Card',
                        'paypal' => 'PayPal',
                    ]),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('created_from')
                            ->label('Order Date From'),
                        \Filament\Forms\Components\DatePicker::make('created_until')
                            ->label('Order Date Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Order from ' . \Carbon\Carbon::parse($data['created_from'])->toFormattedDateString();
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Order until ' . \Carbon\Carbon::parse($data['created_until'])->toFormattedDateString();
                        }
                        return $indicators;
                    }),

                Tables\Filters\Filter::make('total_amount')
                    ->form([
                        \Filament\Forms\Components\TextInput::make('amount_from')
                            ->label('Amount From ($)')
                            ->numeric(),
                        \Filament\Forms\Components\TextInput::make('amount_until')
                            ->label('Amount Until ($)')
                            ->numeric(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['amount_from'],
                                fn (Builder $query, $amount): Builder => $query->where('total_amount', '>=', $amount),
                            )
                            ->when(
                                $data['amount_until'],
                                fn (Builder $query, $amount): Builder => $query->where('total_amount', '<=', $amount),
                            );
                    }),
            ])
            ->actions([
                Action::make('view_details')
                    ->label('View Details')
                    ->icon('heroicon-m-eye')
                    ->color('info')
                    ->modalHeading(fn (CheckoutOrder $record): string => "Order Details: {$record->order_id}")
                    ->modalContent(fn (CheckoutOrder $record): \Illuminate\Contracts\View\View => view(
                        'filament.modals.order-details',
                        ['order' => $record]
                    ))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),

                Action::make('view_items')
                    ->label('Items')
                    ->icon('heroicon-m-list-bullet')
                    ->color('warning')
                    ->modalHeading(fn (CheckoutOrder $record): string => "Order Items: {$record->order_id}")
                    ->modalContent(fn (CheckoutOrder $record): \Illuminate\Contracts\View\View => view(
                        'filament.modals.order-items',
                        ['order' => $record]
                    ))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),

                Action::make('copy_order_id')
                    ->label('Copy ID')
                    ->icon('heroicon-m-clipboard')
                    ->color('gray')
                    ->action(function (CheckoutOrder $record) {
                        // This would need JavaScript to actually copy to clipboard
                        // For now, we'll show a notification
                        \Filament\Notifications\Notification::make()
                            ->title('Order ID: ' . $record->order_id)
                            ->body('Order ID ready to copy')
                            ->info()
                            ->send();
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->poll('60s') // Auto refresh every 60 seconds
            ->emptyStateHeading('No orders found')
            ->emptyStateDescription('Orders from importers will appear here when they make purchases.')
            ->emptyStateIcon('heroicon-o-shopping-cart');
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('refresh')
                ->label('Refresh')
                ->icon('heroicon-m-arrow-path')
                ->action(fn () => $this->dispatch('$refresh')),
                
            \Filament\Actions\Action::make('export')
                ->label('Export Orders')
                ->icon('heroicon-m-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    \Filament\Notifications\Notification::make()
                        ->title('Export feature coming soon!')
                        ->body('Order export functionality will be available in future updates.')
                        ->info()
                        ->send();
                }),
        ];
    }
}
