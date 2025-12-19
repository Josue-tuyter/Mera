<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BackedEnum;

class Reportes extends Page
{

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-arrow-down';
    protected static ?string $navigationLabel = 'Reportes';
    protected static ?string $title = 'Reportes';
    protected string $view = 'filament.pages.reportes';
}
