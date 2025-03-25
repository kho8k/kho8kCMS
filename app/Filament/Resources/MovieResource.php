<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovieResource\Pages;
use App\Filament\Resources\MovieResource\RelationManagers;
use App\Models\Movie;
use App\Models\Actor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class MovieResource extends Resource
{
    protected static ?string $model = Movie::class;

    protected static ?string $navigationIcon = 'heroicon-o-tv';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                ->schema([
                    Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Thông tin phim')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                            ->label('Tên phim')
                            ->required()
                            ->placeholder('Trò Chơi Con Mực')
                            ->maxLength(1024)
                            ->columnSpan(3)
                            ->afterStateUpdated(function ($state, $get, $set) {
                                if (!$get('slug')) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                            Forms\Components\TextInput::make('origin_name')
                            ->label('Tên gốc')
                            ->required()
                            ->placeholder('Squid Game')
                            ->maxLength(1024)
                            ->columnSpan(3),

                            Forms\Components\TextInput::make('slug')
                            ->label('Đường dẫn tĩnh')
                            ->placeholder('tro-choi-con-muc')
                            ->helperText('Nếu không điền, hệ thống sẽ tự tạo từ tên phim')
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),

                            Forms\Components\RichEditor::make('content')
                            ->label('Nội dung')
                            ->columnSpanFull(),

                            Forms\Components\TextInput::make('notify')
                            ->label('Thông báo/Ghi chú')
                            ->placeholder('Tuần này hoãn chiếu')
                            ->columnSpan(3),

                            Forms\Components\TextInput::make('showtimes')
                            ->label('Lịch chiếu phim')
                            ->placeholder('21h tối hằng ngày')
                            ->columnSpan(3),

                            Forms\Components\TextInput::make('trailer_url')
                            ->label('Trailer Youtube URL')
                            ->url()
                            ->columnSpanFull(),

                            Forms\Components\TextInput::make('episode_time')
                            ->label('Thời lượnng tập phim')
                            ->placeholder('45 phút')
                            ->columnSpan(2),

                            Forms\Components\TextInput::make('episode_current')
                            ->label('Tập phim hiện tại')
                            ->placeholder('Tập 5')
                            ->columnSpan(2),

                            Forms\Components\TextInput::make('episode_total')
                            ->label('Tổng số tập phim')
                            ->placeholder('12 tập')
                            ->columnSpan(2),

                            Forms\Components\TextInput::make('language')
                            ->label('Nhãn/Ngôn ngữ')
                            ->placeholder('Tiếng Việt')
                            ->columnSpan(2),

                            Forms\Components\TextInput::make('quality')
                            ->label('Chất lượng')
                            ->placeholder('HD')
                            ->columnSpan(2),

                            Forms\Components\TextInput::make('publish_year')
                            ->label('Năm xuất bản')
                            ->integer()
                            ->placeholder('2023')
                            ->columnSpan(2),
                        ]),
                        Forms\Components\Tabs\Tab::make('Phân loại')
                        ->icon('heroicon-o-tag')
                        ->schema([
                            Forms\Components\Radio::make('type')
                            ->label('Định dạng')
                            ->required()
                            ->default('single')
                            ->options([
                                'single' => 'Phim lẻ',
                                'series' => 'Phim bộ',
                            ])
                            ->columnSpan(3),

                            Forms\Components\Radio::make('status')
                            ->label('Tình trạng')
                            ->required()
                            ->default('completed')
                            ->options([
                                'trailer' => 'Sắp chiếu',
                                'ongoing' => 'Đang chiếu',
                                'completed' => 'Hoàn thành',
                            ])
                            ->columnSpan(3),

                            Forms\Components\Select::make('categories')
                            ->label('Thể loại')
                            ->placeholder('Nhập để tìm kiếm thể loại')
                            ->multiple()
                            ->relationship('categories', 'name')
                            ->preload()
                            ->searchable()
                            ->createOptionForm([
                                Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                    ->label('Tên thể loại')
                                    ->maxLength(255)
                                    ->placeholder('Hành động')
                                    ->unique(ignoreRecord: true)
                                    ->required()
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
                                ]),
                            ])
                            ->createOptionModalHeading('Tạo nhanh Thể loại')
                            ->columnSpanFull(),

                            Forms\Components\Select::make('regions')
                            ->label('Khu vực')
                            ->placeholder('Nhập để tìm kiếm khu vực')
                            ->relationship('regions', 'name')
                            ->preload()
                            ->searchable()
                            ->createOptionForm([
                                Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                    ->label('Tên khu vực')
                                    ->maxLength(255)
                                    ->placeholder('Việt Nam')
                                    ->unique(ignoreRecord: true)
                                    ->required()
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
                                    ->helperText('Nếu không điền, hệ thống sẽ tự tạo từ tên khu vực'),
                                ]),
                            ])
                            ->createOptionModalHeading('Tạo nhanh Khu vực')
                            ->columnSpan(3),

                            Forms\Components\Select::make('directors')
                            ->label('Đạo diễn')
                            ->placeholder('Nhập để tìm kiếm đạo diễn')
                            ->relationship('directors', 'name')
                            ->preload()
                            ->searchable()
                            ->createOptionForm([
                                Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                    ->label('Tên đạo diễn')
                                    ->maxLength(255)
                                    ->placeholder('Hwang Dong Hyuk')
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->afterStateUpdated(
                                        function ($state, $get, $set) {
                                            if (!$get('slug')) {
                                                $set('slug', Str::slug($state));
                                            }
                                        }
                                    )
                                    ->afterStateUpdated(function ($state, $set) {
                                        $set('name_md5', md5($state));
                                    }),

                                    Forms\Components\Hidden::make('name_md5')
                                    ->required()
                                    ->unique(ignoreRecord: true),

                                    Forms\Components\TextInput::make('slug')
                                    ->label('Đường dẫn tĩnh')
                                    ->maxLength(500)
                                    ->placeholder('hwang-dong-hyuk')
                                    ->unique(ignoreRecord: true)
                                    ->rules(['alpha_dash'])
                                    ->helperText('Nếu không điền, hệ thống sẽ tự tạo từ tên đạo diễn')
                                ]),
                            ])
                            ->createOptionModalHeading('Tạo nhanh Đạo diễn')
                            ->columnSpan(3),

                            Forms\Components\Select::make('actors')
                            ->label('Diễn viên')
                            ->placeholder('Nhập để tìm kiếm diễn viên')
                            ->multiple()
                            ->relationship('actors', 'name')
                            ->preload()
                            ->searchable()
                            ->createOptionForm([
                                Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                    ->label('Tên diễn viên')
                                    ->maxLength(255)
                                    ->placeholder('Gong Yoo')
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->afterStateUpdated(
                                        function ($state, $get, $set) {
                                            if (!$get('slug')) {
                                                $set('slug', Str::slug($state));
                                            }
                                        }
                                    )
                                    ->afterStateUpdated(function ($state, $set) {
                                        $set('name_md5', md5($state));
                                    }),

                                    Forms\Components\Hidden::make('name_md5')
                                    ->required()
                                    ->unique(ignoreRecord: true),

                                    Forms\Components\TextInput::make('slug')
                                    ->label('Đường dẫn tĩnh')
                                    ->maxLength(255)
                                    ->placeholder('gong-yoo')
                                    ->unique(ignoreRecord: true)
                                    ->rules(['alpha_dash'])
                                    ->helperText('Nếu không điền, hệ thống sẽ tự tạo từ tên diễn viên'),
                                ]),
                            ])
                            ->createOptionModalHeading('Tạo nhanh Diễn viên')
                            ->columnSpanFull(),

                            Forms\Components\Select::make('tags')
                            ->label('Từ khóa')
                            ->placeholder('Nhập để tìm kiếm từ khóa')
                            ->multiple()
                            ->relationship('tags', 'name')
                            ->preload()
                            ->searchable()
                            ->createOptionForm([
                                Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                    ->label('Tên từ khóa')
                                    ->maxLength(255)
                                    ->placeholder('Squid Game')
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->afterStateUpdated(
                                        function ($state, $get, $set) {
                                            if (!$get('slug')) {
                                                $set('slug', Str::slug($state));
                                            }
                                        }
                                    )
                                    ->afterStateUpdated(function ($state, $set) {
                                        $set('name_md5', md5($state));
                                    }),

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
                                ]),
                            ])
                            ->createOptionModalHeading('Tạo nhanh Từ khóa')
                            ->columnSpanFull(),

                            Forms\Components\Select::make('studios')
                            ->label('Studio')
                            ->placeholder('Nhập để tìm kiếm studio')
                            ->relationship('studios', 'name')
                            ->preload()
                            ->searchable()
                            ->createOptionForm([
                                Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                    ->label('Tên studio')
                                    ->maxLength(255)
                                    ->placeholder('Siren Pictures Inc.')
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->afterStateUpdated(
                                        function ($state, $get, $set) {
                                            if (!$get('slug')) {
                                                $set('slug', Str::slug($state));
                                            }
                                        }
                                    )
                                    ->afterStateUpdated(function ($state, $set) {
                                        $set('name_md5', md5($state));
                                    }),

                                    Forms\Components\Hidden::make('name_md5')
                                    ->required()
                                    ->unique(ignoreRecord: true),

                                    Forms\Components\TextInput::make('slug')
                                    ->label('Đường dẫn tĩnh')
                                    ->maxLength(255)
                                    ->placeholder('siren-pictures-inc')
                                    ->unique(ignoreRecord: true)
                                    ->rules(['alpha_dash'])
                                    ->helperText('Nếu không điền, hệ thống sẽ tự tạo từ tên studio'),
                                ]),
                            ])
                            ->createOptionModalHeading('Tạo nhanh Studio')
                            ->columnSpanFull(),
                        ]),
                        Forms\Components\Tabs\Tab::make('Tập phim')
                        ->icon(icon: 'heroicon-o-film')
                        ->schema([
                            Forms\Components\Repeater::make('episodes')
                            ->label('Tập phim')
                            ->relationship('episodes')
                            ->schema([
                                Forms\Components\TextInput::make('server')
                                ->label('Tên server')
                                ->placeholder('Thuyết minh #1')
                                ->columnSpan(3),

                                Forms\Components\TextInput::make('name')
                                ->label('Tên tập')
                                ->placeholder('Tập 1')
                                ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state)))
                                ->columnSpan(3),

                                Forms\Components\TextInput::make('slug')
                                ->placeholder('tap-1')
                                ->label('Đường dẫn tĩnh')
                                ->helperText('Nếu không điền, hệ thống sẽ tự tạo từ tên tập')
                                ->columnSpan(2),

                                Forms\Components\Select::make('type')
                                ->label('Loại')
                                ->options([
                                    'embedded' => 'Nhúng',
                                    'm3u8' => 'M3U8',
                                ])
                                ->default('embedded')
                                ->selectablePlaceholder(false)
                                ->columnSpan(2),

                                Forms\Components\TextInput::make('link')
                                ->label('Đường dẫn phim')
                                ->url()
                                ->columnSpan(2),
                            ])
                            ->addActionLabel('Thêm Tập phim')
                            ->cloneable()
                            ->addActionAlignment(Alignment::End)
                            ->columns(6)
                            ->columnSpanFull(),
                        ]),
                        Forms\Components\Tabs\Tab::make('Cập nhật')
                        ->icon('heroicon-o-arrow-path')
                        ->schema([
                            Forms\Components\TextInput::make('update_handler')
                            ->label('Trình cập nhật')
                            ->default('')
                            ->readOnly()
                            ->columnSpanFull(),

                            Forms\Components\TextInput::make('update_identity')
                            ->label('ID cập nhật')
                            ->default('')
                            ->readOnly()
                            ->columnSpanFull(),
                        ]),
                        Forms\Components\Tabs\Tab::make('Khác')
                        ->icon('heroicon-o-question-mark-circle')
                        ->schema([
                            Forms\Components\TextInput::make('view_day')
                            ->label('Lượt xem trong ngày')
                            ->integer()
                            ->default(0)
                            ->columnSpan(2),

                            Forms\Components\TextInput::make('view_week')
                            ->label('Lượt xem trong tuần')
                            ->integer()
                            ->default(0)
                            ->columnSpan(2),

                            Forms\Components\TextInput::make('view_month')
                            ->label('Lượt xem trong tháng')
                            ->integer()
                            ->default(0)
                            ->columnSpan(2),

                            Forms\Components\TextInput::make('view_total')
                            ->label('Lượt xem tổng')
                            ->integer()
                            ->default(0)
                            ->columnSpanFull(),

                            Forms\Components\TextInput::make('rating_count')
                            ->label('Số lượng đánh giá')
                            ->integer()
                            ->default(0)
                            ->columnSpan(3),

                            Forms\Components\TextInput::make('rating_star')
                            ->label('Đánh giá theo sao')
                            ->placeholder('1 - 5')
                            ->default(5)
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(5)
                            ->columnSpan(3),
                        ]),
                    ])->columns(6)->columnSpan(2),

                    Forms\Components\Grid::make(1)
                    ->schema([
                        Forms\Components\Section::make('Minh họa Phim')
                        ->schema([
                            Forms\Components\FileUpload::make('thumb_url')
                            ->label('Thumb')
                            ->image()
                            ->maxSize(5120)
                            ->directory('movieThumb')
                            ->visibility('public'),

                            Forms\Components\FileUpload::make(name: 'poster_url')
                            ->label('Poster')
                            ->image()
                            ->maxSize(5120)
                            ->directory('moviePoster')
                            ->visibility('public'),
                        ]),

                        Forms\Components\Section::make('Loại phim')
                        ->schema([
                            Forms\Components\Toggle::make('is_shown_in_theater')
                            ->label('Phim chiếu rạp'),

                            Forms\Components\Toggle::make('is_copyright')
                            ->label('Phim có bản quyền'),

                            Forms\Components\Toggle::make('is_sensitive_content')
                            ->label('Phim có nội dung người lớn'),

                            Forms\Components\Toggle::make('is_recommended')
                            ->label('Phim đề cử'),
                        ]),
                    ])->columnSpan(1),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('movie_info')
                ->label('Thông tin phim')
                ->sortable()
                ->html()
                ->getStateUsing(
                    fn ($record) => "
                        <strong style=\"color:Purple;\">{$record->name}</strong> <span style=\"color:Green;\">[{$record->publish_year}]</span>
                        <br>
                        <span style=\"color:Lightblue;\">({$record->origin_name})</span> <span style=\"color:Red\">[{$record->episode_current}]</span>
                    "
                ),
                Tables\Columns\TextColumn::make('type')
                ->label('Loại phim')
                ->sortable()
                ->badge()
                ->color(fn ($state) => match ($state) {
                    'single' => 'gray',
                    'series' => 'primary'
                }),

                Tables\Columns\TextColumn::make('status')
                ->label('Tình trạng')
                ->sortable()
                ->badge()
                ->color(fn ($state) => match ($state) {
                    'trailer' => 'info',
                    'ongoing' => 'warning',
                    'completed' => 'success',
                }),
                Tables\Columns\ImageColumn::make('thumb_url')->height(150)->width(105)->label('Thumb'),
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
            'index' => Pages\ListMovies::route('/'),
            'create' => Pages\CreateMovie::route('/create'),
            'edit' => Pages\EditMovie::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Quản lý chính';
    }
}
