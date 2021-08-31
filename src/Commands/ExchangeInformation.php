<?php

namespace Nidavellir\CryptoCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Nidavellir\Crawler\Binance\Pipelines\ExchangeInformation\ExchangeInformation as ExchangeInformationPipeline;
use Nidavellir\CryptoCrawler\Pipelines\GetCoinPricePipeline;

class ExchangeInformation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto:exchange-information {canonical? : The canonical to be fetched (e..g: ADAUSDT)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loads a specific canonical into Nidavellir (or all of them)';

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
        $crawler = app('crypto.crawler');

        $canonical = strtoupper($this->argument('canonical'));

        if ($canonical) {
            dispatch(function () use ($canonical, $crawler) {
                $crawler::onPipeline(ExchangeInformationPipeline::class)
                ->set('canonical', $canonical)
                ->set('parameters', ['symbol' => $canonical])
                ->crawl();
            });
        } else {
            dispatch(function () use ($canonical, $crawler) {
                $crawler::onPipeline(ExchangeInformationPipeline::class)
                ->set('canonical', $canonical)
                ->crawl();
            });
        }

        return 0;
    }
}
