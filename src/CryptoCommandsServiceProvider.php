<?php

namespace Nidavellir\CryptoCommands;

use Illuminate\Support\ServiceProvider;
use Nidavellir\CryptoCommands\Commands\CreateCoin;
use Nidavellir\CryptoCommands\Commands\GetCoinPrice;
use Nidavellir\CryptoCommands\Commands\GetGeckoCoins;

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
            CreateCoin::class,
            GetCoinPrice::class,
            GetGeckoCoins::class,
        ]);
    }
}
