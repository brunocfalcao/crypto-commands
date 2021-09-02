<?php

namespace Nidavellir\CryptoCommands;

use Illuminate\Support\ServiceProvider;
use Nidavellir\CryptoCommands\Commands\CrawlCanonical;
use Nidavellir\CryptoCommands\Commands\CreateCrawler;
use Nidavellir\CryptoCommands\Commands\ExchangeInformation;
use Nidavellir\CryptoCommands\Commands\Klines;

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
            ExchangeInformation::class,
            CreateCrawler::class,
            Klines::class,
            CrawlCanonical::class,
        ]);
    }
}
