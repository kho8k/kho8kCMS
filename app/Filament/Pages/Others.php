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

class Others extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-hashtag';

    protected static string $view = 'filament.pages.others';

    public $data = [];
    public function mount(): void
    {
        $this->form->fill([
            'social_facebook_app_id' => Setting::getValue('social_facebook_app_id', ''),
            'site_scripts_facebook_sdk' => Setting::getValue('site_scripts_facebook_sdk', ''),
            'site_scripts_google_analytics' => Setting::getValue('site_scripts_google_analytics', ''),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(3)
                ->schema([
                    Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\TextInput::make('social_facebook_app_id')
                                ->label(Setting::getName('social_facebook_app_id', 'Facebook App ID')),

                            Forms\Components\Textarea::make('site_scripts_facebook_sdk')
                                ->label(Setting::getName('site_scripts_facebook_sdk', 'Facebook JS SDK script tag'))
                                ->rows(10)
                                ->rules(['regex:/^([a-zA-Z0-9.-]+\.[a-zA-Z]{2,})$/']),

                            Forms\Components\Textarea::make('site_scripts_google_analytics')
                                ->label(Setting::getName('site_scripts_google_analytics', 'Google analytics script tag'))
                                ->rows(10)
                                ->rules(['regex:/^([a-zA-Z0-9.-]+\.[a-zA-Z]{2,})$/']),

                        ])
                        ->columnSpan(2),
                ]),
        ])->statePath('data');
    }

    public function submit()
    {
        Setting::set(
            'social_facebook_app_id',
            'Facebook App ID',
            'social_facebook_app_id',
            $this->data['social_facebook_app_id'],
            '{"name":"value","type":"text"}',
            'others',
            0,
        );
        Setting::set(
            'site_scripts_facebook_sdk',
            'Facebook JS SDK script tag',
            'site_scripts_facebook_sdk',
            $this->data['site_scripts_facebook_sdk'],
            '{"name":"value","type":"code"}',
            'others',
            0,
        );
        Setting::set(
            'site_scripts_google_analytics',
            'Google analytics script tag',
            'site_scripts_google_analytics',
            $this->data['site_scripts_google_analytics'],
            '{"name":"value","type":"code"}',
            'others',
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
