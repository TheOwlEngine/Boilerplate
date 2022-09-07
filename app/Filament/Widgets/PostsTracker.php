<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;

class PostsTracker extends BarChartWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Blog Posts';

    public ?string $filter = 'today';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }
 
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'backgroundColor' => '#F59E0C',
                    'label' => 'Blog posts created',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}
