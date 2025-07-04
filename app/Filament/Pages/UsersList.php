<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables;
use App\Models\User;
use Filament\Tables\Columns\TextColumn;

class UsersList extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'User List';
    protected static ?string $title = 'User List';
    protected static string $view = 'filament.pages.users-list';

    protected function getTableQuery()
    {
        return User::query();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('user_id')->label('ID')->sortable(),
            TextColumn::make('name')->label('Name')->searchable()->sortable(),
            TextColumn::make('email')->label('Email')->searchable(),
            TextColumn::make('country')->label('Negara')->searchable(),
            TextColumn::make('phone')->label('Telepon')->searchable(),
            TextColumn::make('role')->label('Role')->badge(),
        ];
    }
}