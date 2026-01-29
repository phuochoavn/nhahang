<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $todayRevenue = Order::whereDate('created_at', today())->sum('total_amount');
        $todayOrders = Order::whereDate('created_at', today())->count();

        return [
            Stat::make('Doanh thu hôm nay', number_format($todayRevenue) . ' đ')
                ->description('Tổng doanh thu trong ngày')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
            Stat::make('Đơn hàng hôm nay', $todayOrders)
                ->description('Số lượng đơn hàng mới')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('primary'),
        ];
    }
}
