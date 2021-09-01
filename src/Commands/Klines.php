<?php

namespace Nidavellir\CryptoCommands\Commands;

use Illuminate\Console\Command;
use Nidavellir\Crawler\Binance\BinanceCrawler;
use Nidavellir\Crawler\Binance\Pipelines\Klines\Klines as KlinesPipeline;

class Klines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto:kline {canonical? : The canonical kline to be fetched (e..g: ADAUSDT)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches candlesticks for a specific symbol, or all of them';

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
        $canonical = strtoupper($this->argument('canonical'));

        if ($canonical) {
            dispatch(function () use ($canonical) {
                BinanceCrawler::onPipeline(KlinesPipeline::class)
                ->set('canonical', $canonical)
                ->set('parameters', ['symbol' => $canonical])
                ->crawl();
            });
        } else {
            dispatch(function () use ($canonical) {
                BinanceCrawler::onPipeline(ExchangeInformationPipeline::class)
                ->set('canonical', $canonical)
                ->crawl();
            });
        }

        return 0;
    }
}
