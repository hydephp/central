<?php

namespace App\Filament\Widgets;

class AccountWidget extends \Filament\Widgets\AccountWidget
{
    protected int|string|array $columnSpan = 2;

    protected static string $view = 'filament/widgets/account-widget';
}
