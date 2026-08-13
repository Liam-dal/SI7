<?php

namespace App\Providers;

use A17\Twill\Facades\TwillNavigation;
use A17\Twill\View\Components\Navigation\NavigationLink;
use App\Models\SiteSetting;
use App\Models\Project;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Homepage feature buckets use the Twill module key, while project
        // blocks/media continue to store the concrete model class.
        Relation::morphMap([
            'projects' => Project::class,
        ]);

        // 본문 이미지 블록은 원본 비율(default) 하나만 사용합니다.
        // 사이트 상세, 전체 에디터, Preview에서 같은 crop을 참조하도록 통일합니다.
        config()->set('twill.block_editor.crops', [
            'image' => [
                'default' => [[
                    'name' => 'default',
                    'ratio' => 0,
                    'minValues' => ['width' => 100, 'height' => 100],
                ]],
            ],
            'images' => [
                'default' => [[
                    'name' => 'default',
                    'ratio' => 0,
                    'minValues' => ['width' => 100, 'height' => 100],
                ]],
            ],
        ]);

        TwillNavigation::addLink(
            NavigationLink::make()
                ->forSingleton('homepage')
                ->title('Homepage')
                ->setChildren([
                    NavigationLink::make()->forSingleton('homepage')->title('Feature projects'),
                ])
                ->doNotAddSelfAsFirstChild()
        );

        TwillNavigation::addLink(
            NavigationLink::make()
                ->forModule('projects')
                ->title('Projects')
                ->setChildren([
                    NavigationLink::make()->forModule('categories')->title('Categories'),
                    NavigationLink::make()->forModule('sectors')->title('Sectors'),
                ])
        );
        TwillNavigation::addLink(
            NavigationLink::make()
                ->forSingleton('about')
                ->title('About')
                ->setChildren([
                    NavigationLink::make()->forModule('people')->title('People'),
                    NavigationLink::make()->forModule('teamRoles')->title('Roles'),
                    NavigationLink::make()->forSingleton('about')->title('Overview'),
                ])
                ->doNotAddSelfAsFirstChild()
        );
        TwillNavigation::addLink(NavigationLink::make()->forModule('guides')->title('Guide'));
        TwillNavigation::addLink(
            NavigationLink::make()
                ->forSingleton('contact')
                ->title('Contact')
                ->setChildren([
                    NavigationLink::make()->forModule('offices')->title('Offices'),
                ])
                ->doNotAddSelfAsFirstChild()
        );
        TwillNavigation::addLink(NavigationLink::make()->forModule('downloads'));
        TwillNavigation::addLink(NavigationLink::make()->forSingleton('siteSetting')->title('Settings'));

        View::composer('site.*', function ($view) {
            $view->with('siteSettings', SiteSetting::query()->first());
        });

        // 번역 블록 값 정규화: 번역 기능 전 저장된 문자열과, 이후 저장된
        // 배열(['ko'=>.., 'en'=>..]) 형태를 모두 안전하게 처리한다.
        // (translatedInput()은 배열을 가정해 문자열이면 array_filter에서 터짐)
        View::share('blockValue', function ($block, string $name) {
            $value = $block->input($name);

            if (is_array($value)) {
                $locale = app()->getLocale();
                $fallback = config('translatable.fallback_locale', 'ko');
                $nonEmpty = array_values(array_filter($value, fn ($v) => $v !== null && $v !== ''));

                return $value[$locale] ?? $value[$fallback] ?? ($nonEmpty[0] ?? '');
            }

            return $value ?? '';
        });
    }
}
