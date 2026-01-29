<?php

namespace App\Filament\Admin\Widgets;


use App\Models\Product; // Changed from OrderItem
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class TopProducts extends BaseWidget
{
    protected static ?string $heading = 'Top món bán chạy';
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->withSum('orderItems', 'quantity')
                    ->orderByDesc('order_items_sum_quantity')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Món ăn'),
                Tables\Columns\TextColumn::make('order_items_sum_quantity')
                    ->label('Số lượng bán')
                    ->badge(),
            ]);
    }
}
