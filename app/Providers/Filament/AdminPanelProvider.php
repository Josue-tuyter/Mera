<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Enums\UserMenuPosition;
use Filament\Actions\Action;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
        ->default()
        ->id('admin')
        ->path('admin')

        ->font('SN Pro')
        ->login()
        ->passwordReset() 

            //para que le nav salga arriba
            //->topNavigation()
            //navbar retactil
            ->sidebarCollapsibleOnDesktop()
            ->collapsedSidebarWidth('9rem')


            //->sidebarFullyCollapsibleOnDesktop()
            ->favicon('favicon.ico')
            ->globalSearch(false) // Deshabilita el buscador global
            //logo de la aplicacion
            ->brandLogo(asset('images/logo.png'))
            //tamaño del logo
            ->brandLogoHeight('5rem')

            ->colors([
                'primary'   => \Filament\Support\Colors\Color::hex('#4E2C0F'),   // Marrón Chocolate Profundo
                'gray'      => \Filament\Support\Colors\Color::hex('#D9A50B'),   // Crema Pergamino
                'success'   => \Filament\Support\Colors\Color::hex('#606C38'),   // Verde Follaje Cacao
                'warning'   => \Filament\Support\Colors\Color::hex('#D4A373'),   // Amarillo Mazorca Madura
                'danger'    => \Filament\Support\Colors\Color::hex('#BC4749'),   // Rojo Óxido
                'info'      => \Filament\Support\Colors\Color::hex('#2A9D8F'),   // Verde Agua Suave
            ])
            //personaliaction of color wiht theme css
            ->viteTheme('resources/css/filament/admin/theme.css')

            //login page personalizada

            //Disabling dark mode
            ->darkMode(false)

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
                
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                //FilamentInfoWidget::class,
                

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
                Authenticate::class,
                \App\Http\Middleware\FilamentAuthenticate::class,
            ])

            ->viteTheme('resources/css/filament/admin/theme.css');

        

            
    }
}
