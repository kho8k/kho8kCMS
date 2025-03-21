<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudioResource\Pages;
use App\Filament\Resources\StudioResource\RelationManagers;
use App\Models\Studio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class StudioResource extends Resource
{
    protected static ?string $model = Studio::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                ->schema([
                    Forms\Components\Section::make('Tạo Studio')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Tên studio')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Siren Pictures Inc.')
                            ->unique(ignoreRecord: true)
                            ->afterStateUpdated(function ($state, $set) {
                                $set('slug', Str::slug($state));
                            })
                            ->afterStateUpdated(function ($state, $set) {
                                $set('name_md5', md5($state));
                            }),
                        
                        Forms\Components\Hidden::make('name_md5')
                            ->required()
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('slug')
                            ->label('Đường dẫn tĩnh')
                            ->maxLength(500)
                            ->placeholder('siren-pictures-inc')
                            ->unique(ignoreRecord: true)
                            ->rules(['alpha_dash'])
                            ->helperText('Nếu không điền, hệ thống sẽ tự tạo từ tên studio')
                            ->columnSpanFull(),
                    ])->columns(2)->columnSpan(2),

                    Forms\Components\Section::make('Minh họa Studio')
                    ->schema([
                        Forms\Components\FileUpload::make('thumb_url')
                            ->label('Ảnh studio')
                            ->image()
                            ->maxSize(5120)
                            ->directory('studio')
                            ->visibility('public'),
                    ])->columnSpan(1),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->label('Tên studio'),
                Tables\Columns\TextColumn::make('slug')->sortable()->label('Đường dẫn tĩnh'),
                Tables\Columns\ImageColumn::make('thumb_url')->circular()->label('Ảnh'),
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
            'index' => Pages\ListStudios::route('/'),
            'create' => Pages\CreateStudio::route('/create'),
            'edit' => Pages\EditStudio::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Phân loại';
    }
}
