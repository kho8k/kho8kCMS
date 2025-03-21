<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatalogResource\Pages;
use App\Filament\Resources\CatalogResource\RelationManagers;
use App\Models\Catalog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CatalogResource extends Resource
{
    protected static ?string $model = Catalog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Tạo Danh mục')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Tên danh mục')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Phim bộ')
                        ->unique(ignoreRecord: true)
                        ->afterStateUpdated(
                            function ($state, $get, $set) {
                                if (!$get('slug')) {
                                    $set('slug', Str::slug($state));
                                }
                            }
                        )
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('slug')
                        ->label('Đường dẫn tĩnh')
                        ->maxLength(255)
                        ->placeholder('phim-bo')
                        ->unique(ignoreRecord: true)
                        ->rules(['alpha_dash'])
                        ->helperText('Nếu không điền, hệ thống sẽ tự tạo từ tên danh mục')
                        ->columnSpan(2),

                    Forms\Components\TextInput::make('paginate')
                        ->label('Phân trang')
                        ->integer()
                        ->required()
                        ->placeholder('20')
                        ->columnSpan(2),
                    
                    Forms\Components\TextInput::make('value')
                        ->label('Giá trị')
                        ->placeholder('relation_tables,relation_field,relation_value|find_by_field_1,find_by_fiel_2,...,find_by_field_n|value_1,value_2,...,value_n|sort_by_field|sort_algo')
                        ->columnSpanFull(),
                    
                    Forms\Components\TextInput::make('seo_title')
                        ->label('Tiêu đề SEO')
                        ->columnSpan(3),
                    
                    Forms\Components\TextInput::make('seo_key')
                        ->label('Keyword SEO')
                        ->columnSpan(3),
                    
                    Forms\Components\Textarea::make('seo_des')
                        ->label('Mô tả SEO')
                        ->rows(5)
                        ->columnSpanFull(),
                ])->columns(6),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->label('Tên danh mục'),
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
            'index' => Pages\ListCatalogs::route('/'),
            'create' => Pages\CreateCatalog::route('/create'),
            'edit' => Pages\EditCatalog::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Phân loại';
    }
}
