<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use App\Models\Product;
use Filament\Tables\Actions\Action;
use Filament\Actions\Action as HeaderAction;
use Filament\Support\Enums\Severity;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class ProductApproval extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static string $view = 'filament.pages.product-approval';

    protected static ?string $navigationLabel = 'Product Approval';

    protected static ?string $title = 'Product Approval';

    protected static ?int $navigationSort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(Product::query())
            ->columns([
                Tables\Columns\TextColumn::make('product_id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),                Tables\Columns\TextColumn::make('product_sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                    
                Tables\Columns\TextColumn::make('product_name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                    
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Eksportir')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('category')
                    ->label('Category')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Electronics' => 'info',
                        'Fashion' => 'success',
                        'Food' => 'warning',
                        'Automotive' => 'danger',
                        default => 'gray',
                    }),
                    
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('USD')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->label('Stock')
                    ->numeric()
                    ->sortable(),                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'archived' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'archived' => 'Archived',
                    ])
                    ->default('pending'),
                    
                Tables\Filters\SelectFilter::make('category')
                    ->label('Category')
                    ->options([
                        'Electronics' => 'Electronics',
                        'Fashion' => 'Fashion',
                        'Food' => 'Food',
                        'Automotive' => 'Automotive',
                        'Health' => 'Health',
                        'Home' => 'Home',
                        'Sports' => 'Sports',
                        'Other' => 'Other',
                    ]),
            ])
            ->actions([
                Action::make('view_details')
                    ->label('View')
                    ->icon('heroicon-m-eye')
                    ->color('info')
                    ->modalHeading(fn (Product $record): string => "Product Details: {$record->product_name}")
                    ->modalContent(fn (Product $record): \Illuminate\Contracts\View\View => view(
                        'filament.modals.product-details',
                        ['product' => $record]
                    ))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),
                    
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Product')
                    ->modalDescription('Are you sure you want to approve this product? It will be visible to importers in the catalog.')
                    ->action(function (Product $record) {
                        $record->update(['status' => 'approved']);
                        
                        Notification::make()
                            ->title('Product Approved!')
                            ->body("Product '{$record->product_name}' has been approved successfully.")
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Product $record): bool => $record->status === 'pending'),
                    
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Reject Product')
                    ->modalDescription('Are you sure you want to reject this product? It will not be visible to importers.')
                    ->action(function (Product $record) {
                        $record->update(['status' => 'rejected']);
                        
                        Notification::make()
                            ->title('Product Rejected!')
                            ->body("Product '{$record->product_name}' has been rejected.")
                            ->danger()
                            ->send();
                    })
                    ->visible(fn (Product $record): bool => $record->status === 'pending'),
                    
                Action::make('archive')
                    ->label('Archive')
                    ->icon('heroicon-m-archive-box')
                    ->color('secondary')
                    ->requiresConfirmation()
                    ->modalHeading('Archive Product')
                    ->modalDescription('Are you sure you want to archive this product?')
                    ->action(function (Product $record) {
                        $record->update(['status' => 'archived']);
                        
                        Notification::make()
                            ->title('Product Archived!')
                            ->body("Product '{$record->product_name}' has been archived.")
                            ->info()
                            ->send();
                    })
                    ->visible(fn (Product $record): bool => in_array($record->status, ['approved', 'rejected'])),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('approve_selected')
                    ->label('Approve Selected')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Selected Products')
                    ->modalDescription('Are you sure you want to approve all selected products?')
                    ->action(function ($records) {
                        $count = $records->where('status', 'pending')->count();
                        $records->where('status', 'pending')->each(function ($record) {
                            $record->update(['status' => 'approved']);
                        });
                        
                        Notification::make()
                            ->title('Products Approved!')
                            ->body("{$count} products have been approved successfully.")
                            ->success()
                            ->send();
                    }),
                    
                Tables\Actions\BulkAction::make('reject_selected')
                    ->label('Reject Selected')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Reject Selected Products')
                    ->modalDescription('Are you sure you want to reject all selected products?')
                    ->action(function ($records) {
                        $count = $records->where('status', 'pending')->count();
                        $records->where('status', 'pending')->each(function ($record) {
                            $record->update(['status' => 'rejected']);
                        });
                        
                        Notification::make()
                            ->title('Products Rejected!')
                            ->body("{$count} products have been rejected.")
                            ->danger()
                            ->send();
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->poll('30s'); // Auto refresh every 30 seconds
    }    protected function getHeaderActions(): array
    {
        return [
            HeaderAction::make('refresh')
                ->label('Refresh')
                ->icon('heroicon-m-arrow-path')
                ->action(fn () => $this->dispatch('$refresh')),
        ];
    }
}
