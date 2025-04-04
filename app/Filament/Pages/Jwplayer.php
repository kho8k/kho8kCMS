<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Button;
use Filament\Forms\Components\Actions\Action;

class Jwplayer extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-play';



    protected static string $view = 'filament.pages.jwplayer';

    public $data = [];
    public function mount(): void
    {
        $this->form->fill([
            'jwplayer_license' => Setting::getValue('jwplayer_license', 'ITWMv7t88JGzI0xPwW8I0+LveiXX9SWbfdmt0ArUSyc='),
            'jwplayer_logo_file' => Setting::getValue('jwplayer_logo_file', ''),
            'jwplayer_logo_link' => Setting::getValue('jwplayer_logo_link', ''),
            'jwplayer_logo_position' => Setting::getValue('jwplayer_logo_position', ''),
            'jwplayer_advertising_file' => Setting::getValue('jwplayer_advertising_file', ''),
            'jwplayer_advertising_skipoffset' => Setting::getValue('jwplayer_advertising_skipoffset', ''),

        ]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(3)
                ->schema([
                    Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\TextInput::make('jwplayer_license')
                                ->label(Setting::getName('jwplayer_license', 'Mã bản quyền Jwplayer')),

                            Forms\Components\TextInput::make('jwplayer_logo_link')
                                ->label(Setting::getName('jwplayer_logo_link', 'Đường dẫn logo Jwplayer')),

                            Forms\Components\Select::make('jwplayer_logo_position')
                                ->label(Setting::getName('jwplayer_logo_position', 'Vị trí logo Jwplayer'))
                                ->options([
                                    'top-left' => 'Trên trái',
                                    'top-right' => 'Trên phải',
                                    'bottom-right' => 'Dưới phải',
                                    'bottom-left' => 'Dưới trái',
                                    'control-bar' => 'Thanh điều khiển',
                                ])
                                ->default(Setting::getValue('jwplayer_logo_position', '')),


                            Forms\Components\TextInput::make('jwplayer_advertising_file')
                                ->label(Setting::getName('jwplayer_advertising_file', 'Tệp quảng cáo Jwplayer'))
                                ->id('jwplayer_advertising_file')
                                ->readOnly()
                                ->suffix(new HTMLString('
                                <button
                                type="Button"
                                onclick="(() => {
                                    window.open(\'/file-manager/fm-button\', \'fm\', \'width=900,height=600\')
                                    window.fmSetLink = (url) => {
                                        let advertisingFilePath = url.replace(location.origin + \'/storage/\', \'\')
                                        document.querySelector(\'#jwplayer_advertising_file\').value = advertisingFilePath;
                                        document.querySelector(\'#jwplayer_advertising_file\').dispatchEvent(new Event(\'input\'));
                                    };
                                })()">
                                    Chọn Logo
                                </button>')),

                            Forms\Components\TextInput::make('jwplayer_advertising_skipoffset')
                                ->label(Setting::getName('jwplayer_advertising_skipoffset', 'Jwplayer advertising skipoffset'))
                                ->integer()
                                ->helperText('giây (s)'),
                        ])
                        ->columnSpan(2),

                    Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\TextInput::make('jwplayer_logo_file')
                                ->label(Setting::getName('jwplayer_logo_file', 'Logo Jwplayer'))
                                ->id('jwplayer_logo_file')
                                ->readOnly()
                                ->suffix(new HTMLString('
                                <button 
                                style="color: black;"
                                type="Button"
                                onclick="(() => {
                                    window.open(\'/file-manager/fm-button\', \'fm\', \'width=900,height=600\')
                                    window.fmSetLink = (url) => {
                                        let imagePath = url.replace(location.origin + \'/storage/\', \'\')
                                        document.querySelector(\'#jwplayer_logo_file\').value = imagePath;
                                        document.querySelector(\'#logoImage\').src = \'/storage/\' + imagePath;
                                        document.querySelector(\'#jwplayer_logo_file\').dispatchEvent(new Event(\'input\'));
                                        let imageLogo = document.querySelector(\'#logoImage\');
                                        imageLogo.src = \'/storage/\' + imagePath;
                                        imageLogo.style.display = \'block\';
                                    };
                                })()">
                                    Chọn Logo
                                </button>')),
                            Forms\Components\Placeholder::make('')
                                ->label('Hình ảnh jwplayer logo file')
                                ->content(function ($get) {
                                    $url = $get('jwplayer_logo_file');
                                    if ($url) {
                                        return new HTMLString('<img id="logoImage" src="' . Storage::url($url) . '" style="width: auto; height: auto;"/>');
                                    }
                                    return new HTMLString('<img id="logoImage" style="display: none;"/>');
                                }),
                        ])
                        ->columnSpan(1),
                ]),
        ])->statePath('data');
    }

    public function submit()
    {
        Setting::set(
            'jwplayer_license',
            'Jwplayer license',
            'jwplayer_license',
            $this->data['jwplayer_license'],
            '{"name":"value","type":"text"}',
            'jwplayer',
            0,
        );
        Setting::set(
            'jwplayer_logo_file',
            'Jwplayer logo image',
            'jwplayer_logo_file',
            $this->data['jwplayer_logo_file'],
            '{"name":"value","type":"ckfinder"}',
            'jwplayer',
            0,
        );
        Setting::set(
            'jwplayer_logo_link',
            'Jwplayer logo link',
            'jwplayer_logo_link',
            $this->data['jwplayer_logo_link'],
            '{"name":"value","type":"text"}',
            'jwplayer',
            0,
        );
        Setting::set(
            'jwplayer_logo_position',
            'Jwplayer logo position',
            'jwplayer_logo_position',
            $this->data['jwplayer_logo_position'],
            '{"name":"value","type":"select_from_array","options":{"top-left":"Top left","top-right":"Top right","bottom-right":"Bottom right","bottom-left":"Bottom left","control-bar":"Control bar"}}',
            'jwplayer',
            0,
        );
        Setting::set(
            'jwplayer_advertising_file',
            'Jwplayer advertising vast file',
            'jwplayer_advertising_file',
            $this->data['jwplayer_advertising_file'],
            '{"name":"value","type":"ckfinder"}',
            'jwplayer',
            0,
        );
        Setting::set(
            'jwplayer_advertising_skipoffset',
            'Jwplayer advertising skipoffset',
            'jwplayer_advertising_skipoffset',
            $this->data['jwplayer_advertising_skipoffset'],
            '{"name":"value","type":"number","hint":"gi\\u00e2y"}',
            'jwplayer',
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
