<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Monzer\FilamentChatifyIntegration\ChatifyPlugin;
use App\Filament\Widgets\StatsOverview;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationGroup;
use App\Filament\Plugins\CustomChatifyPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->plugin(new CustomChatifyPlugin())
            ->brandLogo(asset('images/logo.png'))
            ->favicon(asset('images/favicon.png'))
            ->login()
            ->colors([
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'primary' => Color::Green,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                StatsOverview::class,
            ])
            ->navigationItems([
                NavigationItem::make('Add Property')
                    ->url(fn (): string => route('filament.admin.resources.properties.create'))
                    ->icon('heroicon-o-plus-circle')
                    ->group('Quick Actions')
                    ->sort(1),
                NavigationItem::make('Messages')
                    ->url(fn (): string => route('chat.index'))
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->group('Communication')
                    ->sort(1)
                    ->badge(fn () => \Chatify\Facades\ChatifyMessenger::countUnseenMessages(auth()->id()) ?: null),
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Resources')
                    ->collapsed(false),
                NavigationGroup::make()
                    ->label('Communication')
                    ->collapsed(false),
                NavigationGroup::make()
                    ->label('Quick Actions')
                    ->collapsed(false),
            ])
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->sidebarCollapsibleOnDesktop()
            ->renderHook(
                'panels::sidebar.start',
                fn () => view('components.add-property-button')
            )
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
                Authenticate::class,
            ]);
    }
}












