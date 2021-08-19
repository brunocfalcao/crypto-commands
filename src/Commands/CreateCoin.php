<?php

namespace Nidavellir\CryptoCommands\Commands;

use Illuminate\Console\Command;
use Nidavellir\CryptoCrawler\CryptoCrawler;
use Nidavellir\CryptoCrawler\Pipelines\CreateCoinPipeline;

class CreateCoin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto:create-coin {id : The coingecko coin id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new coin in the Nivadellier crypto platform';

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
        $id = $this->argument('id');

        dispatch(function () use ($id) {
            CryptoCrawler::set('coin', $id)
                 ->onPipeline(CreateCoinPipeline::class)
                 ->crawl();
        });

        return 0;
    }
}
