<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
// use Filament\Resources\Pages\ListRecords\Tab;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
    // public function getTabs(): array
    // {
    //     return [
    //         'all' => Tab::make('All Users'),
    //         'pending' => Tab::make('Pending Approval')
    //             ->modifyQueryUsing(fn(Builder $query) => $query->where('is_verified', false))
    //             ->badge(User::query()->where('is_verified', false)->count())
    //             ->badgeColor('warning'),
    //         'verified' => Tab::make('Verified')
    //             ->modifyQueryUsing(fn(Builder $query) => $query->where('is_verified', true)),
    //     ];
    // }
}
