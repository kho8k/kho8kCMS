<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EpisodeResource\Pages;
use App\Filament\Resources\EpisodeResource\RelationManagers;
use App\Models\Episode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EpisodeResource extends Resource
{
    protected static ?string $model = Episode::class;

    protected static ?string $navigationIcon = 'heroicon-o-viewfinder-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                ->schema([
                    Forms\Components\Section::make('Thông tin Tập')
                    ->schema([
                        Forms\Components\Select::make('type')
                        ->label('Loại')
                        ->options([
                            'embedded' => 'Nhúng',
                            'm3u8' => 'M3U8',
                        ])
                        ->required()
                        ->default('embedded')
                        ->selectablePlaceholder(false),
                        
                        Forms\Components\TextInput::make('link')
                        ->label('Nguồn phát')
                        ->url(),
                    ])->columnSpan(1),

                    Forms\Components\Section::make('Thông tin Lỗi')
                    ->schema([
                        Forms\Components\Toggle::make('has_report')
                        ->label('Đánh dấu đang lỗi')
                        ->columnSpanFull(),

                        Forms\Components\Textarea::make('report_message')
                        ->label('Nội dung lỗi')
                        ->rows(3)
                        ->columnSpanFull(),

                    ])->columnSpan(1),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Episode::query()->where('has_report', true)
            )
            ->columns([
                Tables\Columns\TextColumn::make('movie.name')
                ->label('Tên phim')
                ->sortable(),

                Tables\Columns\TextColumn::make('name')
                ->label('Tập'),

                Tables\Columns\TextColumn::make('type')
                ->label('Loại')
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListEpisodes::route('/'),
            'create' => Pages\CreateEpisode::route('/create'),
            'edit' => Pages\EditEpisode::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Quản lý chính';
    }
}
