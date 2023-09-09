<?php

namespace App;

use App\Http\Middleware\GuestableAuthenticate;
use App\Utils\HeroIcon;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Panel;
use Filament\Widgets;
use Filament\Pages;

class AppPanel
{
    public static function make(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('app')
            ->path('')
            ->login()
            ->colors([
                'primary' => Color::Indigo,
            ])
            ->favicon(url('favicon.ico'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->groups([
                    NavigationGroup::make('Quick Navigation')->items([
                        NavigationItem::make('Dashboard')
                            ->icon('heroicon-o-home')
                            ->isActiveWhen(fn(): bool => request()->routeIs('filament.admin.pages.dashboard') || request()->url() === url(''))
                            ->url(fn(): string => Pages\Dashboard::getUrl()),
                    ]),
                    NavigationGroup::make('HydePHP Services')->items([
                        static::externalLinkItem('Main Website', 'https://hydephp.com', 'home'),
                        static::externalLinkItem('Documentation', 'https://hydephp.com/docs/1.x', 'book-open'),
                        static::externalLinkItem('Open Analytics', 'https://analytics.hydephp.com', 'chart-bar-square'),
                    ]),
                    NavigationGroup::make('Community Resources')->items([
                        static::externalLinkItem('Discord Server', 'https://discord.hydephp.com', HeroIcon::ChatBubbleLeftRight),
                        static::externalLinkItem('Community Portal', 'https://hydephp.com/community.html', HeroIcon::UserGroup),
                        static::externalLinkItem('Developer Resources', 'https://hydephp.com/community.html#developers', HeroIcon::CommandLine),
                        static::externalLinkItem('GitHub Organisation', 'https://github.com/hydephp', HeroIcon::CodeBracketSquare),
                        static::externalLinkItem('Source Monorepo', 'https://github.com/hydephp/develop', HeroIcon::BuildingLibrary),
                    ]),
                ]);
            })
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                GuestableAuthenticate::class,
            ]);
    }

    protected static function externalLinkItem(string $label, string $url, null|string|HeroIcon $icon = null): NavigationItem
    {
        if ($icon instanceof HeroIcon) {
            $icon = $icon->value;
        }

        return NavigationItem::make($label)
            ->url($url)
            ->icon($icon ? "heroicon-o-$icon" : null)
            ->openUrlInNewTab();
    }
}
