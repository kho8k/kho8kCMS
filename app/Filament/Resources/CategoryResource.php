<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Tạo Thể loại')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Tên thể loại')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Hành động')
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
                        ->placeholder('hanh-dong')
                        ->unique(ignoreRecord: true)
                        ->rules(['alpha_dash'])
                        ->helperText('Nếu không điền, hệ thống sẽ tự tạo từ tên thể loại'),
                    
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
                Tables\Columns\TextColumn::make('name')->sortable()->label('Tên thể loại'),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Phân loại';
    }
}
