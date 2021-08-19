<?php

namespace Nidavellir\CryptoCommands\Commands;

use Illuminate\Console\Command;
use Nidavellir\CryptoCrawler\CryptoCrawler;
use Nidavellir\CryptoCrawler\Pipelines\GetCoinPricePipeline;
use Nidavellir\CryptoCube\Models\Coin;

class GetCoinPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto:get-coin-price {ids? : The coingecko coin ids separated by comma}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets the coin(s) price';

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
        $ids = $this->argument('ids') ?? Coin::all('coin_id')->pluck('coin_id')->join(',');

        dispatch(function () use ($ids) {
            CryptoCrawler::set('coins', $ids)
                 ->onPipeline(GetCoinPricePipeline::class)
                 ->crawl();
        });

        return 0;
    }
}
