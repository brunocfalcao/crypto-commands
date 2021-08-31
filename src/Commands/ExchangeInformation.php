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
    protected $signature = 'crypto:exchange-information {symbol? : The symbol to be fetched (e..g: ADAUSDT)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loads a specific symbol into Nidavellir (or all of them)';

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

        if ($this->argument('symbol')) {
            $crawler::onPipeline(ExchangeInformationPipeline::class)
                ->set('parameters', ['symbol' => strtoupper($this->argument('symbol'))])
                ->crawl();
        } else {
            $crawler::onPipeline(ExchangeInformationPipeline::class)
                ->crawl();
        }

        return;

        $response = Http::withHeaders(
            ['X-MBX-APIKEY' => env('CRYPTO_CRAWLER_API')]
        )->get('https://api.binance.com/api/v3/exchangeInfo');

        dd($response->json()['symbols'][0]);

        return;

        dd($crawler::onPipeline(GetCoins::class))
                   ->crawl();

        CryptoCrawler::set('coins', $ids)
             ->onPipeline(GetCoinPricePipeline::class)
             ->crawl();

        return 0;
    }
}
