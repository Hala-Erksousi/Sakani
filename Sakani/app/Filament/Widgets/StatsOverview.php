<?php

namespace App\Filament\Widgets;
use Filament\Widgets\StatsOverviewWidget\stat;
use App\Models\User;
use App\Models\Apartment;
use Filament\Widgets\StatsOverviewWidget;

class StatsOverview extends StatsOverviewWidget
{   
    protected function getStats(): array
    {
        return [
            Stat::make('Total number of apartments', Apartment::count())
                ->description('Total apartments listed')
                ->icon('heroicon-o-building-office-2')
                 ->chart([15, 4, 10, 2, 12, 4, 9])
                ->color('info'),

            Stat::make('Total Users', User::count())
                ->description('Registered users in the system')
                ->descriptionIcon('heroicon-m-user-group')
                ->chart([7, 2, 10, 3, 15, 4, 17]) 
                ->color('success'),

            Stat::make('Pending Approval', User::where('is_verified', false)->count())
                ->description('Users needing review')
                ->descriptionIcon('heroicon-m-clock')
                ->chart([15, 4, 10, 2, 12, 4, 9])
                ->color('warning'),
        ];
    }
}
