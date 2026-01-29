<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TableResource\Pages;
use App\Filament\Admin\Resources\TableResource\RelationManagers;
use App\Models\Table as TableModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TableResource extends Resource
{
    protected static ?string $model = TableModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Bàn ăn';
    protected static ?string $modelLabel = 'Bàn';
    protected static ?string $pluralModelLabel = 'Danh sách bàn';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Tên bàn')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'available' => 'Trống',
                        'occupied' => 'Có khách',
                    ])
                    ->required()
                    ->default('available'),
                Forms\Components\TextInput::make('qr_code_url')
                    ->label('Đường dẫn QR')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên bàn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'occupied' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'available' => 'Trống',
                        'occupied' => 'Có khách',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('qr_code_url')
                    ->label('Link QR')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download_qr')
                    ->label('Tải QR')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => route('table.download_qr', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('print_qr')
                    ->label('In QR')
                    ->icon('heroicon-o-printer')
                    ->url(fn ($record) => route('table.print_qr', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTables::route('/'),
            'create' => Pages\CreateTable::route('/create'),
            'edit' => Pages\EditTable::route('/{record}/edit'),
        ];
    }
}
