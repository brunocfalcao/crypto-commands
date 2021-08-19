<?php

namespace Nidavellir\CryptoCommands\Commands;

use Illuminate\Console\Command;
use Nidavellir\CryptoCrawler\CryptoCrawler;
use Nidavellir\CryptoCrawler\Pipelines\GetGeckoCoinsPipeline;

class GetGeckoCoins extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto:get-gecko-coins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches all gecko coins into a gecko coins master table (not into coins table!)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        CryptoCrawler::onPipeline(GetGeckoCoinsPipeline::class)
                     ->crawl();

        dispatch(function () {
            CryptoCrawler::onPipeline(GetGeckoCoinsPipeline::class)
                         ->crawl();
        });

        return 0;
    }
}
