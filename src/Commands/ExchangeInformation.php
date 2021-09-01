<?php

namespace Nidavellir\CryptoCommands\Commands;

use Illuminate\Console\Command;
use Nidavellir\Crawler\Binance\BinanceCrawler;
use Nidavellir\Crawler\Binance\Pipelines\ExchangeInformation\ExchangeInformation as ExchangeInformationPipeline;

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
        $canonical = strtoupper($this->argument('canonical'));

        dispatch(function () use ($canonical) {
            $crawler = BinanceCrawler::onPipeline(ExchangeInformationPipeline::class);

            if ($canonical) {
                $crawler->set('canonical', $canonical)
                        ->set('parameters', ['symbol' => $canonical]);
            }

            $crawler->crawl();
        });

        return 0;
    }
}
