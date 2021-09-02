<?php

namespace Nidavellir\CryptoCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Nidavellir\Crawler\Binance\BinanceCrawler;
use Nidavellir\Crawler\Binance\Pipelines\Klines\Klines as KlinesPipeline;
use Nidavellir\CryptoCommands\Rules\IntervalRule;

class Klines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto:kline {canonical : The canonical kline to be fetched (e..g: ADAUSDT). If not passed, }
                                         {--interval=5m : The interval as defined in Binance API (https://binance-docs.github.io/apidocs/spot/en/#kline-candlestick-streams)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches candlesticks for a specific symbol (e.g. ADAUSDT) for a specific interval (default 15 minutes)';

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
        DB::table('candlesticks')->truncate();

        $canonical = strtoupper($this->argument('canonical'));
        $interval = strtolower($this->option('interval'));

        // Validate interval.
        Validator::make(['interval' => $interval], [
            'interval' => new IntervalRule(),
        ])->validate();

        dispatch(function () use ($canonical, $interval) {
            BinanceCrawler::onPipeline(KlinesPipeline::class)
                          ->set('canonical', $canonical)
                          ->set(
                              'parameters',
                              ['symbol'   => $canonical,
                                  'interval' => $interval, ]
                          )
                          ->crawl();
        });

        return 0;
    }
}
