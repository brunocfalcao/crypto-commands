<?php

namespace Nidavellir\CryptoCommands\Commands;

use Illuminate\Console\Command;
use Nidavellir\Crawler\Binance\BinanceCrawler;
use Nidavellir\Crawler\Binance\Pipelines\ExchangeInformation\ExchangeInformation as ExchangeInformationPipeline;

class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates all Binance tokens. New ones will send notification';

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
        dispatch(function () {
            BinanceCrawler::onPipeline(ExchangeInformationPipeline::class)
                      ->crawl();
        });

        return 0;
    }
}
