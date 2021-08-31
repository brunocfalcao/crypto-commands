<?php

namespace Nidavellir\CryptoCommands\Commands;

use Illuminate\Console\Command;
use Nidavellir\CryptoCube\Models\Crawler;

class CreateCrawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto:create-crawler {acronym : The crawler acronym} {--live=false : Crawler is live already}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new crawler';

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
        if (Crawler::firstWhere('acronym', $this->argument('acronym'))) {
            $this->error('Crawler already exists!');
            return -1;
        }

        Crawler::create([
            'acronym' => $this->argument('acronym'),
            'is_live' => $this->option('live') ? true : false
        ]);

        $this->info('Crawler created');

        return 0;
    }
}
