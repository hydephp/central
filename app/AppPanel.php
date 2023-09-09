<?php

namespace App;

use App\Filament\Pages\BrandMedia;
use App\Utils\HeroIcon;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;

class AppPanel
{
    public static function navigation(NavigationBuilder $builder): NavigationBuilder
    {
        return $builder->groups([
            NavigationGroup::make('Quick Navigation')->items([
                NavigationItem::make('Dashboard')
                    ->icon('heroicon-o-home')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard') || request()->url() === url(''))
                    ->url(fn (): string => Pages\Dashboard::getUrl()),

                NavigationItem::make('Brand Media')
                    ->icon(BrandMedia::getNavigationIcon())
                    ->isActiveWhen(fn (): bool => request()->routeIs(BrandMedia::getRouteName()))
                    ->url(fn (): string => BrandMedia::getUrl()),
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
    }

    protected static function externalLinkItem(string $label, string $url, string|HeroIcon $icon = null): NavigationItem
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
