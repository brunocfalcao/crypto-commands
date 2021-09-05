<?php

namespace Nidavellir\CryptoCommands;

use Illuminate\Support\ServiceProvider;

final class CryptoCommandsServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->registerCommands();
    }

    private function registerCommands()
    {
        $this->commands([
            UpdateTokens::class,
        ]);
    }
}
