<?php

use Filament\Widgets\StatsOverviewWidget\stat;
use App\Models\User;
use App\Models\Apartment;
use Filament\Widgets\StatsOverviewWidget; // تأكد من استيراد الموديل

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats():array
    {
        return [
            Stat::make('Total numbers of users', User::count())
                ->description('Total users in the system')
                ->icon('heroicon-o-user-group')
                ->color('success'),
                
          
            Stat::make('Pending Approval', User::where('is_verified', false)->count())
                ->description('Users needing review')
                ->icon('heroicon-o-document-magnifying-glass')
                ->color('warning'), 
                
         
            Stat::make('Total number of apartments', Apartment::count())
                ->description('Total apartments listed')
                ->icon('heroicon-o-building-office-2')
                ->color('info'),
        ];
    }
}