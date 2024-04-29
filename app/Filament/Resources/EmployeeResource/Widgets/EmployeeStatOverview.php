<?php

namespace App\Filament\Resources\EmployeeResource\Widgets;

use App\Models\Country;
use App\Models\Employee;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class EmployeeStatOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $us = Country::where('country_code', 'US')->withCount('employees')->first();
        $uk = Country::where('country_code', 'UK')->withCount('employees')->first();
        return [
            Card::make('All Employees', Employee::all()->count()),
            Card::make('US Employees', $us->employees_count),
            Card::make('UK Employees', $uk->employees_count),
        ];
    }
}
