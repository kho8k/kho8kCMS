<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegionResource\Pages;
use App\Filament\Resources\RegionResource\RelationManagers;
use App\Models\Region;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class RegionResource extends Resource
{
    protected static ?string $model = Region::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Tạo Vùng')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Tên vùng')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Việt Nam')
                        ->unique(ignoreRecord: true)
                        ->afterStateUpdated(
                            function ($state, $get, $set) {
                                if (!$get('slug')) {
                                    $set('slug', Str::slug($state));
                                }
                            }
                        ),

                    Forms\Components\TextInput::make('slug')
                        ->label('Đường dẫn tĩnh')
                        ->maxLength(255)
                        ->placeholder('viet-nam')
                        ->unique(ignoreRecord: true)
                        ->rules(['alpha_dash'])
                        ->helperText('Nếu không điền, hệ thống sẽ tự tạo từ tên vùng'),
                    
                    Forms\Components\TextInput::make('seo_title')
                        ->label('Tiêu đề SEO'),
                    
                    Forms\Components\TextInput::make('seo_key')
                        ->label('Keyword SEO'),
                    
                    Forms\Components\Textarea::make('seo_des')
                        ->label('Mô tả SEO')
                        ->rows(5)
                        ->columnSpanFull(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->label('Tên vùng'),
                Tables\Columns\TextColumn::make('slug')->sortable()->label('Đường dẫn tĩnh'),
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
            'index' => Pages\ListRegions::route('/'),
            'create' => Pages\CreateRegion::route('/create'),
            'edit' => Pages\EditRegion::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Phân loại';
    }
}
