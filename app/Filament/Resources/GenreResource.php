<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GenreResource\Pages;
use App\Filament\Resources\GenreResource\RelationManagers;
use App\Models\Genre;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GenreResource extends Resource
{
    protected static ?string $model = Genre::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Tạo Thể loại')
                ->schema([
                    Forms\Components\TextInput::make('genreName')
                        ->label('Tên thể loại')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Hành động')
                        ->id('genreName'),

                    Forms\Components\TextInput::make('staticURL')
                        ->label('Đường dẫn tĩnh')
                        ->maxLength(500)
                        ->required()
                        ->placeholder('hanh-dong')
                        ->id('staticURL'),
                ])->columns(2),

                Forms\Components\View::make('filament.utils.autoComplete')
                ->viewData([
                    'payload' => 'genreName',
                    'target' => 'staticURL'
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('genreName')->sortable()->label('Tên thể loại'),
                Tables\Columns\TextColumn::make('staticURL')->sortable()->label('Đường dẫn tĩnh'),
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
            'index' => Pages\ListGenres::route('/'),
            'create' => Pages\CreateGenre::route('/create'),
            'edit' => Pages\EditGenre::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Phân loại';
    }
}
