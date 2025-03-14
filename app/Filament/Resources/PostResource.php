<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Quản lý nội dung';
    protected static ?string $navigationLabel = 'Bài viết';
    protected static ?string $pluralNavigationLabel = 'Bài viết';
    protected static ?string $slug = 'posts';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin bài viết')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Tác giả')
                            ->relationship('author', 'name')
                            ->required(),
                        
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $state, callable $set) => $set('slug', Str::slug($state))),
                      
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        
                        Forms\Components\FileUpload::make('featured_image')
                            ->image()
                            ->directory('posts/featured-images')
                            ->visibility('public')
                            ->columnSpanFull(),
                        
                        Forms\Components\RichEditor::make('content')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Xuất bản')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Bản nháp',
                                'published' => 'Đã xuất bản',
                            ])
                            ->default('draft')
                            ->required(),
                            
                        Forms\Components\DateTimePicker::make('published_at')
                            ->default(now())
                            ->label('Ngày xuất bản'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\ImageColumn::make('featured_image')
                ->label('Ảnh đại diện')
                ->circular(),
            
            Tables\Columns\TextColumn::make('title')
                ->label('Tiêu đề')
                ->searchable()
                ->sortable(),
            
            Tables\Columns\TextColumn::make('author.name')
                ->label('Tác giả')
                ->searchable()
                ->sortable(),
            
            Tables\Columns\TextColumn::make('status')
                ->label('Trạng thái')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'draft' => 'gray',
                    'published' => 'success',
                })
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'draft' => 'Bản nháp',
                    'published' => 'Đã xuất bản',
                }),
            
            Tables\Columns\TextColumn::make('published_at')
                ->label('Ngày xuất bản')
                ->dateTime('d/m/Y H:i')
                ->sortable(),
            
            Tables\Columns\TextColumn::make('created_at')
                ->label('Ngày tạo')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'draft' => 'Bản nháp',
                    'published' => 'Đã xuất bản',
                ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}