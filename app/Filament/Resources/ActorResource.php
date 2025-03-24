<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActorResource\Pages;
use App\Filament\Resources\ActorResource\RelationManagers;
use App\Models\Actor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ActorResource extends Resource
{
    protected static ?string $model = Actor::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                ->schema([
                    Forms\Components\Section::make('Tạo Diễn viên')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Tên diễn viên')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Gong Yoo')
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

                        Forms\Components\Select::make('gender')
                            ->label('Giới tính')
                            ->options([
                                'male' => 'Nam',
                                'female' => 'Nữ',
                                'other' => 'Khác',
                            ]),

                        Forms\Components\TextInput::make('slug')
                            ->label('Đường dẫn tĩnh')
                            ->maxLength(500)
                            // ->required()
                            ->placeholder('gong-yoo')
                            ->unique(ignoreRecord: true)
                            ->rules(['alpha_dash'])
                            ->helperText('Nếu không điền, hệ thống sẽ tự tạo từ tên diễn viên')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('seo_title')
                            ->label('Tiêu đề SEO'),
                        
                        Forms\Components\TextInput::make('seo_key')
                            ->label('Keyword SEO'),
                        
                        Forms\Components\Textarea::make('seo_des')
                            ->label('Mô tả SEO')
                            ->rows(5)
                            ->columnSpanFull(),
                    ])->columns(2)->columnSpan(2),

                    Forms\Components\Section::make('Minh họa Diễn viên')
                    ->schema([
                        Forms\Components\FileUpload::make('thumb_url')
                            ->label('Ảnh diễn viên')
                            ->image()
                            ->maxSize(5120)
                            ->directory('actor')
                            ->visibility('public'),
                        
                        Forms\Components\Textarea::make('bio')
                            ->label('Tiểu sử')
                            ->rows(3),
                    ])->columnSpan(1),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->label('Tên diễn viên'),
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
            'index' => Pages\ListActors::route('/'),
            'create' => Pages\CreateActor::route('/create'),
            'edit' => Pages\EditActor::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Phân loại';
    }
}
