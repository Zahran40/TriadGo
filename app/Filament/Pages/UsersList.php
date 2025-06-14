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
    protected static ?string $navigationLabel = 'Daftar User';
    protected static ?string $title = 'Daftar User';
    protected static string $view = 'filament.pages.users-list';

    protected function getTableQuery()
    {
        return User::query();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')->label('Nama')->searchable()->sortable(),
            TextColumn::make('email')->label('Email')->searchable(),
            TextColumn::make('role')->label('Role')->badge(),
        ];
    }
} // <-- tambahkan ini