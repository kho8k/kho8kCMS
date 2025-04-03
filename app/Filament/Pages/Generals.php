<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class Generals extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = 'Chung';
    protected static string $view = 'filament.pages.generals';

    public $data = [];

    public function mount()
    {
        $this->form->fill([
            'site_cache_ttl' => Setting::getValue('site_cache_ttl', 60),
            'site_brand' => Setting::getValue('site_brand', 'movie.com'),
            'site_logo' => Setting::getValue('site_logo', ''),
            'site_image_proxy_url' => Setting::getValue('site_image_proxy_url', ''),
            'site_image_proxy_enable' => Setting::getValue('site_image_proxy_enable', false),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(3)
            ->schema([
                Forms\Components\Section::make()
                ->schema([
                    Forms\Components\TextInput::make('site_cache_ttl')
                        ->label(Setting::getName('site_cache_ttl', 'Thời gian lưu cache'))
                        ->integer()
                        ->helperText('giây (s)'),

                    Forms\Components\Textarea::make('site_brand')
                        ->label(Setting::getName('site_brand', 'Site Brand'))
                        ->rules(['regex:/^([a-zA-Z0-9.-]+\.[a-zA-Z]{2,})$/']),

                    Forms\Components\TextInput::make('site_image_proxy_url')
                        ->label(Setting::getName('site_image_proxy_url', 'Cấu hình proxy'))
                        ->url()
                        ->helperText('{image_url}: biến hình ảnh'),

                    Forms\Components\Toggle::make('site_image_proxy_enable')
                        ->label(Setting::getName('site_image_proxy_enable', 'Sử dụng Proxy cho đường dẫn hình ảnh')),
                ])
                ->columnSpan(2),

                Forms\Components\Section::make()
                ->schema([
                    Forms\Components\TextInput::make('site_logo')
                        ->label(Setting::getName('site_logo', 'Site Logo'))
                        ->id('site_logo')
                        ->readOnly()
                        ->suffix(new HTMLString('
                        <button type="button" onclick="(() => {
                            window.open(\'/file-manager/fm-button\', \'fm\', \'width=900,height=600\')
                            window.fmSetLink = (url) => {
                                let imagePath = url.replace(location.origin + \'/storage/\', \'\')
                                document.querySelector(\'#site_logo\').value = imagePath;
                                document.querySelector(\'#logoImage\').src = \'/storage/\' + imagePath;
                                document.querySelector(\'#site_logo\').dispatchEvent(new Event(\'input\'));
                            };
                        })()">
                            Chọn Logo
                        </button>')),

                    Forms\Components\Placeholder::make('')
                        ->label('Hình ảnh Site Logo')
                        ->content(function ($get) {
                            $url = $get('site_logo');
                            if ($url) {
                                return new HTMLString('<img id="logoImage" src="' . Storage::url($url) . '" alt="Logo" style="object-fit: contain; width: 20vw; height: 20vw;"/>');
                            }
                            return 'Chưa có logo';
                        }),
                ])
                ->columnSpan(1),
            ]),
        ])->statePath('data');
    }

    public function submit()
    {
        Setting::set(
            'site_cache_ttl',
            'Thời gian lưu cache',
            'site_cache_ttl',
            $this->data['site_cache_ttl'],
            '{"name":"value","type":"text","hint":"giây (s)"}',
            'generals',
            0,
        );
        Setting::set(
            'site_brand',
            'Site Brand',
            'site_brand',
            $this->data['site_brand'],
            '{"name":"value","type":"textarea"}',
            'generals',
            0,
        );
        Setting::set(
            'site_logo',
            'Site Logo',
            'site_logo',
            $this->data['site_logo'],
            '{"name":"value","type":"text"}',
            'generals',
            0,
        );
        Setting::set(
            'site_image_proxy_url',
            'Cấu hình proxy',
            'site_image_proxy_url',
            $this->data['site_image_proxy_url'],
            '{"name":"value","type":"text","hint":"{image_url}: biến hình ảnh"}',
            'generals',
            0,
        );
        Setting::set(
            'site_image_proxy_enable',
            'Sử dụng Proxy cho đường dẫn hình ảnh',
            'site_image_proxy_enable',
            $this->data['site_image_proxy_enable'],
            '{"name":"value","type":"switch","label":"Use proxy link in image path","color":"primary","onLabel":"✓","offLabel":"✕"}',
            'generals',
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
