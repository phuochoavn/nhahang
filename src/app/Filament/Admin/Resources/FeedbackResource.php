<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\FeedbackResource\Pages;
use App\Filament\Admin\Resources\FeedbackResource\RelationManagers;
use App\Models\Feedback;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FeedbackResource extends Resource
{
    protected static ?string $model = Feedback::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Phản hồi';
    protected static ?string $modelLabel = 'Phản hồi';
    protected static ?int $sort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('table_id')
                    ->relationship('table', 'name')
                    ->label('Bàn')
                    ->required(),
                Forms\Components\TextInput::make('rating')
                    ->label('Đánh giá (Sao)')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(5)
                    ->required(),
                Forms\Components\Textarea::make('content')
                    ->label('Nội dung')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('table.name')
                    ->label('Bàn')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Đánh giá')
                    ->formatStateUsing(fn (string $state): string => str_repeat('⭐', $state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('content')
                    ->label('Nội dung')
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Thời gian')
                    ->dateTime('H:i d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListFeedback::route('/'),
            // 'create' => Pages\CreateFeedback::route('/create'),
            // 'edit' => Pages\EditFeedback::route('/{record}/edit'),
        ];
    }
}
