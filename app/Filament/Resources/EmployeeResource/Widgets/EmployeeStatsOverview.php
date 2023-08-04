<?php

namespace App\Filament\Resources\EmployeeResource\Widgets;

use App\Models\Country;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class EmployeeStatsOverview extends ChartWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $countries = Country::query()
            ->select('name')
            ->withCount('employees')
            ->whereHas('employees')
            ->orderBy('name')
            ->get();

        $colors = $countries->map(fn($country) => sprintf('#%06X', crc32($country->name) & 0xFFFFFF))->toArray();

        return [
            'labels'   => $countries->map(fn ($country) => $country->name)->toArray(),
            'datasets' => [
                [
                    'label'           => 'Employees',
                    'data'            => $countries->map(fn ($country) => $country->employees_count)->toArray(),
                    'backgroundColor' => array_map(fn ($color) => $color . 'AA', $colors),
                    'borderColor'     => $colors,
                ],
            ],
        ];
    }
}
