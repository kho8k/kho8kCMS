<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class SEO extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chevron-double-up';

    protected static ?string $navigationLabel = 'SEO';

    protected static string $view = 'filament.pages.s-e-o';

    public $data = [];

    public function mount()
    {
        $this->form->fill([
            'site_meta_siteName' => Setting::getValue('site_meta_siteName', ''),
            'site_meta_shortcut_icon' => Setting::getValue('site_meta_shortcut_icon', ''),
            'site_homepage_title' => Setting::getValue('site_homepage_title', ''),
            'site_meta_description' => Setting::getValue('site_meta_description', ''),
            'site_meta_keywords' => Setting::getValue('site_meta_keywords', ''),
            'site_meta_image' => Setting::getValue('site_meta_image', ''),
            'site_meta_head_tags' => Setting::getValue('site_meta_head_tags', ''),
            'site_movie_title' => Setting::getValue('site_movie_title', ''),
            'site_episode_watch_title' => Setting::getValue('site_episode_watch_title', ''),
            'site_category_title' => Setting::getValue('site_category_title', ''),
            'site_category_des' => Setting::getValue('site_category_des', ''),
            'site_category_key' => Setting::getValue('site_category_key', ''),
            'site_region_title' => Setting::getValue('site_region_title', ''),
            'site_region_des' => Setting::getValue('site_region_des', ''),
            'site_region_key' => Setting::getValue('site_region_key', ''),
            'site_studio_title' => Setting::getValue('site_studio_title', ''),
            'site_studio_des' => Setting::getValue('site_studio_des', ''),
            'site_studio_key' => Setting::getValue('site_studio_key', ''),
            'site_actor_title' => Setting::getValue('site_actor_title', ''),
            'site_actor_des' => Setting::getValue('site_actor_des', ''),
            'site_actor_key' => Setting::getValue('site_actor_key', ''),
            'site_director_title' => Setting::getValue('site_director_title', ''),
            'site_director_des' => Setting::getValue('site_director_des', ''),
            'site_director_key' => Setting::getValue('site_director_key', ''),
            'site_tag_title' => Setting::getValue('site_tag_title', ''),
            'site_tag_des' => Setting::getValue('site_tag_des', ''),
            'site_tag_key' => Setting::getValue('site_tag_key', ''),
            'site_routes_movie' => Setting::getValue('site_routes_movie', ''),
            'site_routes_episode' => Setting::getValue('site_routes_episode', ''),
            'site_routes_category' => Setting::getValue('site_routes_category', ''),
            'site_routes_region' => Setting::getValue('site_routes_region', ''),
            'site_routes_tag' => Setting::getValue('site_routes_tag', ''),
            'site_routes_types' => Setting::getValue('site_routes_types', ''),
            'site_routes_actors' => Setting::getValue('site_routes_actors', ''),
            'site_routes_directors' => Setting::getValue('site_routes_directors', ''),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(3)
            ->schema([
                Forms\Components\Tabs::make()
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Chung')
                    ->schema([
                        Forms\Components\TextInput::make('site_meta_siteName')
                        ->label(Setting::getName('site_meta_siteName', 'Tên Meta site')),

                        Forms\Components\TextInput::make('site_homepage_title')
                        ->label(Setting::getName('site_homepage_title', 'Tiêu đề mặc định')),

                        Forms\Components\Textarea::make('site_meta_description')
                        ->label(Setting::getName('site_meta_description', 'Mô tả Meta'))
                        ->rows(4),

                        Forms\Components\Textarea::make('site_meta_keywords')
                        ->label(Setting::getName('site_meta_keywords', 'Các từ khóa Meta'))
                        ->rows(4),

                        Forms\Components\Textarea::make('site_meta_head_tags')
                        ->label(Setting::getName('site_meta_head_tags', 'Head meta tags'))
                        ->rows(4),
                    ]),
                    Forms\Components\Tabs\Tab::make('Phim')
                    ->schema([
                        Forms\Components\TextInput::make('site_movie_title')
                        ->label(Setting::getName('site_movie_title', 'Mẫu tiêu đề trang thông tin phim'))
                        ->helperText('Thông tin phim: {name}|{origin_name}|{language}|{quality}|{episode_current}|{publish_year}|...'),

                        Forms\Components\TextInput::make('site_episode_watch_title')
                        ->label(Setting::getName('site_episode_watch_title', 'Mẫu tiêu đề trang xem phim'))
                        ->helperText(new HTMLString('
                            Thông tin phim: {movie.name}|{movie.origin_name}|{movie.language}|{movie.quality}|{movie.episode_current}|movie.publish_year}|...
                            <br>
                            Thông tin tập: {name}
                        ')),
                    ]),
                    Forms\Components\Tabs\Tab::make('Thể loại')
                    ->schema([
                        Forms\Components\TextInput::make('site_category_title')
                        ->label(Setting::getName('site_category_title', 'Tiêu đề thể loại mặc định'))
                        ->helperText('Thông tin: {name}'),

                        Forms\Components\TextInput::make('site_category_des')
                        ->label(Setting::getName('site_category_des', 'Mô tả thể loại mặc định'))
                        ->helperText('Thông tin: {name}'),

                        Forms\Components\TextInput::make('site_category_key')
                        ->label(Setting::getName('site_category_key', 'Từ khóa thể loại mặc định'))
                        ->helperText('Thông tin: {name}'),
                    ]),
                    Forms\Components\Tabs\Tab::make('Quốc gia')
                    ->schema([
                        Forms\Components\TextInput::make('site_region_title')
                        ->label(Setting::getName('site_region_title', 'Tiêu đề quốc gia mặc định'))
                        ->helperText('Thông tin: {name}'),

                        Forms\Components\TextInput::make('site_region_des')
                        ->label(Setting::getName('site_region_des', 'Mô tả quốc gia mặc định'))
                        ->helperText('Thông tin: {name}'),

                        Forms\Components\TextInput::make('site_region_key')
                        ->label(Setting::getName('site_region_key', 'Từ khóa quốc gia mặc định'))
                        ->helperText('Thông tin: {name}'),
                    ]),
                    Forms\Components\Tabs\Tab::make('Studio')
                    ->schema([
                        Forms\Components\TextInput::make('site_studio_title')
                        ->label(Setting::getName('site_studio_title', 'Tiêu đề studio mặc định'))
                        ->helperText('Thông tin: {name}'),

                        Forms\Components\TextInput::make('site_studio_des')
                        ->label(Setting::getName('site_studio_des', 'Mô tả studio mặc định'))
                        ->helperText('Thông tin: {name}'),

                        Forms\Components\TextInput::make('site_studio_key')
                        ->label(Setting::getName('site_studio_key', 'Từ khóa studio mặc định'))
                        ->helperText('Thông tin: {name}'),
                    ]),
                    Forms\Components\Tabs\Tab::make('Diễn viên')
                    ->schema([
                        Forms\Components\TextInput::make('site_actor_title')
                        ->label(Setting::getName('site_actor_title', 'Tiêu đề diễn viên'))
                        ->helperText('Thông tin: {name}'),

                        Forms\Components\TextInput::make('site_actor_des')
                            ->label(Setting::getName('site_actor_des', 'Description diễn viên'))
                            ->helperText(new HtmlString('Thông tin: {name}')),

                        Forms\Components\TextInput::make('site_actor_key')
                            ->label(Setting::getName('site_actor_key', 'Keywords diễn viên'))
                            ->helperText('Thông tin: {name}'),
                    ]),
                    Forms\Components\Tabs\Tab::make('Đạo diễn')
                    ->schema([
                        Forms\Components\TextInput::make('site_director_title')
                            ->label(Setting::getName('site_director_title', 'Tiêu đề đạo diễn'))
                            ->helperText('Thông tin: {name}'),

                        Forms\Components\TextInput::make('site_director_des')
                            ->label(Setting::getName('site_director_des', 'Description đạo diễn'))
                            ->helperText(new HtmlString('Thông tin: {name}')),

                        Forms\Components\TextInput::make('site_director_key')
                            ->label(Setting::getName('site_director_key', 'Keywords đạo diễn'))
                            ->helperText('Thông tin: {name}'),
                    ]),
                    Forms\Components\Tabs\Tab::make('Từ khóa')
                    ->schema([
                        Forms\Components\TextInput::make('site_tag_title')
                            ->label(Setting::getName('site_tag_title', 'Tiêu đề tag'))
                            ->helperText('Thông tin: {name}'),

                        Forms\Components\TextInput::make('site_tag_des')
                            ->label(Setting::getName('site_tag_des', 'Description tag'))
                            ->helperText(new HtmlString('Thông tin: {name}')),

                        Forms\Components\TextInput::make('site_tag_key')
                            ->label(Setting::getName('site_tag_key', 'Keywords tag'))
                            ->helperText('Thông tin: {name}'),
                    ]),
                    Forms\Components\Tabs\Tab::make('Slug')
                    ->schema([
                        Forms\Components\TextInput::make('site_routes_movie')
                        ->label(Setting::getName('site_routes_movie', 'Trang thông tin phim'))
                        ->helperText('{movie}, {id} Buộc phải có ít nhất 1 param'),

                        Forms\Components\TextInput::make('site_routes_episode')
                        ->label(Setting::getName('site_routes_episode', 'Trang xem phim'))
                        ->helperText(new HtmlString('{movie}, {movie_id} Ít nhất 1<br>{episode}, {id} Bắt buộc')),

                        Forms\Components\TextInput::make('site_routes_category')
                        ->label(Setting::getName('site_routes_category', 'Trang thể loại'))
                        ->helperText('{category}, {id} Ít nhất 1'),

                        Forms\Components\TextInput::make('site_routes_region')
                        ->label(Setting::getName('site_routes_region', 'Trang quốc gia'))
                        ->helperText('{region}, {id} Ít nhất 1'),

                        Forms\Components\TextInput::make('site_routes_tag')
                        ->label(Setting::getName('site_routes_tag', 'Trang từ khóa'))
                        ->helperText('{tag}, {id} Ít nhất 1'),

                        Forms\Components\TextInput::make('site_routes_types')
                        ->label(Setting::getName('site_routes_types', 'Trang danh sách phim'))
                        ->helperText('{type}, {id} Ít nhất 1'),

                        Forms\Components\TextInput::make('site_routes_actors')
                        ->label(Setting::getName('site_routes_actors', 'Trang diễn viên'))
                        ->helperText('{actor}, {id} Ít nhất 1'),

                        Forms\Components\TextInput::make('site_routes_directors')
                        ->label(Setting::getName('site_routes_directors', 'Trang đạo diễn'))
                        ->helperText('{director}, {id} Ít nhất 1'),
                    ]),
                ])
                ->columnSpan(2),

                Forms\Components\Grid::make(1)
                ->schema([
                    Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('site_meta_shortcut_icon')
                        ->label(Setting::getName('site_meta_shortcut_icon', 'Meta shortcut icon'))
                        ->id('site_meta_shortcut_icon')
                        ->readOnly()
                        ->suffix(new HTMLString('
                        <button type="button" onclick="(() => {
                            window.open(\'/file-manager/fm-button\', \'fm\', \'width=900,height=600\')
                            window.fmSetLink = (url) => {
                                let iconPath = url.replace(location.origin + \'/storage/\', \'\')
                                document.querySelector(\'#site_meta_shortcut_icon\').value = iconPath;
                                document.querySelector(\'#site_meta_shortcut_icon\').dispatchEvent(new Event(\'input\'));
                                let iconImage = document.querySelector(\'#iconImage\');
                                iconImage.src = \'/storage/\' + iconPath;
                                iconImage.style.display = \'block\';
                            };
                        })()">
                            Chọn icon Meta
                        </button>')),

                        Forms\Components\Placeholder::make('')
                        ->label('Hiển thị icon Meta')
                        ->content(function ($get) {
                            $url = $get('site_meta_shortcut_icon');
                            if ($url) {
                                return new HTMLString('<img id="iconImage" src="' . Storage::url($url) . '" alt="Icon" style="display: block; object-fit: contain; width: 20vw; height: 20vw;">');
                            }
                            return new HTMLString('<img id="iconImage" style="display: none; object-fit: contain; width: 20vw; height: 20vw;">');
                        }),
                    ])
                    ->columnSpanFull(),

                    Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('site_meta_image')
                        ->label(Setting::getName('site_meta_image', 'Ảnh Meta'))
                        ->id('site_meta_image')
                        ->readOnly()
                        ->suffix(new HTMLString('
                        <button type="button" onclick="(() => {
                            window.open(\'/file-manager/fm-button\', \'fm\', \'width=900,height=600\')
                            window.fmSetLink = (url) => {
                                let metaImagePath = url.replace(location.origin + \'/storage/\', \'\')
                                document.querySelector(\'#site_meta_image\').value = metaImagePath;
                                document.querySelector(\'#site_meta_image\').dispatchEvent(new Event(\'input\'));
                                let metaImage = document.querySelector(\'#metaImage\');
                                metaImage.src = \'/storage/\' + metaImagePath;
                                metaImage.style.display = \'block\';
                            };
                        })()">
                            Chọn ảnh Meta
                        </button>')),

                        Forms\Components\Placeholder::make('')
                        ->label('Hiển thị ảnh Meta')
                        ->content(function ($get) {
                            $url = $get('site_meta_image');
                            if ($url) {
                                return new HTMLString('<img id="metaImage" src="' . Storage::url($url) . '" alt="Icon" style="display: block; object-fit: contain; width: 20vw; height: 20vw;">');
                            }
                            return new HTMLString('<img id="metaImage" style="display: none; object-fit: contain; width: 20vw; height: 20vw;">');
                        }),
                    ])
                    ->columnSpanFull(),
                ])
                ->columnSpan(1),
            ])
        ])->statePath('data');
    }

    public function submit()
    {
        Setting::set(
            'site_meta_siteName',
            'Tên Meta site',
            'site_meta_siteName',
            $this->data['site_meta_siteName'],
            '{"name":"value","type":"text","tab":"General"}',
            'metas',
            0,
        );
        Setting::set(
            'site_meta_shortcut_icon',
            'Meta shortcut icon',
            'site_meta_shortcut_icon',
            $this->data['site_meta_shortcut_icon'],
            '{"name":"value","type":"lfm","tab":"General"}',
            'metas',
            0,
        );
        Setting::set(
            'site_homepage_title',
            'Tiêu đề mặc định',
            'site_homepage_title',
            $this->data['site_homepage_title'],
            '{"name":"value","type":"text","tab":"General"}',
            'metas',
            0,
        );
        Setting::set(
            'site_meta_description',
            'Mô tả Meta',
            'site_meta_description',
            $this->data['site_meta_description'],
            '{"name":"value","type":"textarea","tab":"General"}',
            'metas',
            0,
        );
        Setting::set(
            'site_meta_keywords',
            'Các từ khóa Meta',
            'site_meta_keywords',
            $this->data['site_meta_keywords'],
            '{"name":"value","type":"textarea","tab":"General"}',
            'metas',
            0,
        );
        Setting::set(
            'site_meta_image',
            'Ảnh Meta',
            'site_meta_image',
            $this->data['site_meta_image'],
            '{"name":"value","type":"lfm","tab":"General"}',
            'metas',
            0,
        );Setting::set(
            'site_meta_head_tags',
            'Head meta tags',
            'site_meta_head_tags',
            $this->data['site_meta_head_tags'],
            '{"name":"value","type":"textarea","tab":"General","attributes":{"rows":5}}',
            'metas',
            0,
        );
        Setting::set(
            'site_movie_title',
            'Mẫu tiêu đề trang thông tin phim',
            'site_movie_title',
            $this->data['site_movie_title'],
            '{"name":"value","type":"text","hint":"Thông tin phim: {name}|{origin_name}|{language}|{quality}|{episode_current}|{publish_year}|...","tab":"Phim"}',
            'metas',
            0,
        );
        Setting::set(
            'site_episode_watch_title',
            'Mẫu tiêu đề trang xem phim',
            'site_episode_watch_title',
            $this->data['site_episode_watch_title'],
            '{"name":"value","type":"text","hint":"Thông tin phim: {movie.name}|{movie.origin_name}|{movie.language}|{movie.quality}|{movie.episode_current}|movie.publish_year}|...<br>Thông tin tập: {name}","tab":"Phim"}',
            'metas',
            0,
        );
        Setting::set(
            'site_category_title',
            'Tiêu đề thể loại mặc định',
            'site_category_title',
            $this->data['site_category_title'],
            '{"name":"value","type":"text","hint":"Thông tin: {name}","tab":"Thể loại"}',
            'metas',
            0,
        );
        Setting::set(
            'site_category_des',
            'Mô tả thể loại mặc định',
            'site_category_des',
            $this->data['site_category_des'],
            '{"name":"value","type":"text","hint":"Thông tin: {name}","tab":"Thể loại"}',
            'metas',
            0,
        );
        Setting::set(
            'site_category_key',
            'Từ khóa thể loại mặc định',
            'site_category_key',
            $this->data['site_category_key'],
            '{"name":"value","type":"text","hint":"Thông tin: {name}","tab":"Thể loại"}',
            'metas',
            0,
        );
        Setting::set(
            'site_region_title',
            'Tiêu đề quốc gia mặc định',
            'site_region_title',
            $this->data['site_region_title'],
            '{"name":"value","type":"text","hint":"Thông tin: {name}","tab":"Quốc gia"}',
            'metas',
            0,
        );
        Setting::set(
            'site_region_des',
            'Mô tả quốc gia mặc định',
            'site_region_des',
            $this->data['site_region_des'],
            '{"name":"value","type":"text","hint":"Thông tin: {name}","tab":"Quốc gia"}',
            'metas',
            0,
        );
        Setting::set(
            'site_region_key',
            'Từ khóa quốc gia mặc định',
            'site_region_key',
            $this->data['site_region_key'],
            '{"name":"value","type":"text","hint":"Thông tin: {name}","tab":"Quốc gia"}',
            'metas',
            0,
        );
        Setting::set(
            'site_studio_title',
            'Tiêu đề studio mặc định',
            'site_studio_title',
            $this->data['site_studio_title'],
            '{"name":"value","type":"text","hint":"Thông tin: {name}","tab":"Studio"}',
            'metas',
            0,
        );
        Setting::set(
            'site_studio_des',
            'Mô tả studio mặc định',
            'site_studio_des',
            $this->data['site_studio_des'],
            '{"name":"value","type":"text","hint":"Thông tin: {name}","tab":"Studio"}',
            'metas',
            0,
        );
        Setting::set(
            'site_studio_key',
            'Từ khóa studio mặc định',
            'site_studio_key',
            $this->data['site_studio_key'],
            '{"name":"value","type":"text","hint":"Thông tin: {name}","tab":"Studio"}',
            'metas',
            0,
        );
        Setting::set(
            'site_actor_title',
            'Tiêu đề diễn viên',
            'site_actor_title',
            $this->data['site_actor_title'],
            '{"name":"value","type":"text","hint":"Th\\u00f4ng tin: {name}","tab":"Di\\u1ec5n Vi\\u00ean"}',
            'metas',
            0,
        );

        Setting::set(
            'site_actor_des',
            'Description diễn viên',
            'site_actor_des',
            $this->data['site_actor_des'],
            '{"name":"value","type":"text","hint":"Th\\u00f4ng tin: {name}","tab":"Di\\u1ec5n Vi\\u00ean"}',
            'metas',
            0,
        );
        Setting::set(
            'site_actor_key',
            'Keywords diễn viên',
            'site_actor_key',
            $this->data['site_actor_key'],
            '{"name":"value","type":"text","hint":"Th\\u00f4ng tin: {name}","tab":"Di\\u1ec5n Vi\\u00ean"}',
            'metas',
            0,
        );

        Setting::set(
            'site_director_title',
            'Tiêu đề đạo diễn',
            'site_director_title',
            $this->data['site_director_title'],
            '{"name":"value","type":"text","hint":"Th\\u00f4ng tin: {name}","tab":"Di\\u1ec5n Vi\\u00ean"}',
            'metas',
            0,
        );

        Setting::set(
            'site_director_des',
            'Description đạo diễn',
            'site_director_des',
            $this->data['site_director_des'],
            '{"name":"value","type":"text","hint":"Th\\u00f4ng tin: {name}","tab":"Di\\u1ec5n Vi\\u00ean"}',
            'metas',
            0,
        );
        Setting::set(
            'site_director_key',
            'Keywords đạo diễn',
            'site_director_key',
            $this->data['site_director_key'],
            '{"name":"value","type":"text","hint":"Th\\u00f4ng tin: {name}","tab":"Di\\u1ec5n Vi\\u00ean"}',
            'metas',
            0,
        );

        Setting::set(
            'site_tag_title',
            'Tiêu đề tag',
            'site_tag_title',
            $this->data['site_tag_title'],
            '{"name":"value","type":"text","hint":"Th\\u00f4ng tin: {name}","tab":"Tag"}',
            'metas',
            0,
        );

        Setting::set(
            'site_tag_des',
            'Description tag',
            'site_tag_des',
            $this->data['site_tag_des'],
            '{"name":"value","type":"text","hint":"Th\\u00f4ng tin: {name}","tab":"Di\\u1ec5n Vi\\u00ean"}',
            'metas',
            0,
        );
        Setting::set(
            'site_tag_key',
            'Keywords tag',
            'site_tag_key',
            $this->data['site_tag_key'],
            '{"name":"value","type":"text","hint":"Th\\u00f4ng tin: {name}","tab":"Di\\u1ec5n Vi\\u00ean"}',
            'metas',
            0,
        );

        Setting::set(
            'site_routes_movie',
            'Trang thông tin phim',
            'site_routes_movie',
            $this->data['site_routes_movie'],
            '{"name":"value","type":"text","hint":"<span class=\\"text-danger\\">{movie}, {id}<\\/span> Bu\\u1ed9c ph\\u1ea3i c\\u00f3 \\u00edt nh\\u1ea5t 1 param","tab":"Slug"}',
            'metas',
            0,
        );

        Setting::set(
            'site_routes_episode',
            'Trang xem phim',
            'site_routes_episode',
            $this->data['site_routes_episode'],
            '{"name":"value","type":"text","hint":"<span class=\\"text-danger\\">{movie}, {movie_id}<\\/span> \\u00cdt nh\\u1ea5t 1<br \\/>\\n<span class=\\"text-danger\\">{episode}, {id}<\\/span> B\\u1eaft bu\\u1ed9c<br \\/>","tab":"Slug"}',
            'metas',
            0,
        );

        Setting::set(
            'site_routes_category',
            'Trang thể loại',
            'site_routes_category',
            $this->data['site_routes_category'],
            '{"name":"value","type":"text","hint":"<span class=\\"text-danger\\">{category}, {id}<\\/span> \\u00cdt nh\\u1ea5t 1","tab":"Slug"}',
            'metas',
            0,
        );

        Setting::set(
            'site_routes_region',
            'Trang quốc gia',
            'site_routes_region',
            $this->data['site_routes_region'],
            '{"name":"value","type":"text","hint":"<span class=\\"text-danger\\">{region}, {id}<\\/span> \\u00cdt nh\\u1ea5t 1","tab":"Slug"}',
            'metas',
            0,
        );

        Setting::set(
            'site_routes_tag',
            'Trang từ khóa',
            'site_routes_tag',
            $this->data['site_routes_tag'],
            '{"name":"value","type":"text","hint":"<span class=\\"text-danger\\">{tag}, {id}<\\/span> \\u00cdt nh\\u1ea5t 1","tab":"Slug"}',
            'metas',
            0,
        );

        Setting::set(
            'site_routes_types',
            'Trang danh sách phim',
            'site_routes_types',
            $this->data['site_routes_types'],
            '{"name":"value","type":"text","hint":"<span class=\\"text-danger\\">{type}, {id}<\\/span> \\u00cdt nh\\u1ea5t 1","tab":"Slug"}',
            'metas',
            0,
        );

        Setting::set(
            'site_routes_actors',
            'Trang danh diễn viên',
            'site_routes_actors',
            $this->data['site_routes_actors'],
            '{"name":"value","type":"text","hint":"<span class=\\"text-danger\\">{actor}, {id}<\\/span> \\u00cdt nh\\u1ea5t 1","tab":"Slug"}',
            'metas',
            0,
        );

        Setting::set(
            'site_routes_directors',
            'Trang danh đạo diễn',
            'site_routes_directors',
            $this->data['site_routes_directors'],
            '{"name":"value","type":"text","hint":"<span class=\\"text-danger\\">{director}, {id}<\\/span> \\u00cdt nh\\u1ea5t 1","tab":"Slug"}',
            'metas',
            0,
        );
        Notification::make()
        ->title('Đã lưu')
        ->success()
        ->send();
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Tùy chỉnh';
    }
}
