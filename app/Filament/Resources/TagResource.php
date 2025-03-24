<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Filament\Resources\TagResource\RelationManagers;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-hashtag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Tạo Từ khóa')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Tên từ khóa')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Squid Game')
                        ->unique(ignoreRecord: true)
                        ->afterStateUpdated(
                            function ($state, $get, $set) {
                                if (!$get('slug')) {
                                    $set('slug', Str::slug($state));
                                }
                            }
                        )
                        ->afterStateUpdated(
                            function ($state, $set) {
                                $set('name_md5', md5($state));
                            }
                        ),

                    Forms\Components\Hidden::make('name_md5')
                        ->required()
                        ->unique(ignoreRecord: true),

                    Forms\Components\TextInput::make('slug')
                        ->label('Đường dẫn tĩnh')
                        ->maxLength(255)
                        ->placeholder('squid-game')
                        ->unique(ignoreRecord: true)
                        ->rules(['alpha_dash'])
                        ->helperText('Nếu không điền, hệ thống sẽ tự tạo từ tên từ khóa'),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->label('Tên từ khóa'),
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
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Phân loại';
    }
}
