<?php

namespace Nidavellir\CryptoCommands\Commands;

use Illuminate\Console\Command;
use Nidavellir\CryptoCube\Models\Symbol;

class CrawlCanonical extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto:crawl-canonical {canonical} : Symbol canonical} {--deactivate : Deactivates a symbol from crawling}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activates/Deactivates a canonical from price crawling';

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
        $canonical = Symbol::firstWhere('canonical', $this->argument('canonical'));

        if ($canonical) {
            if ($this->option('deactivate') == true) {
                $canonical->update(['is_crawling_prices' => false]);
                $this->info('Canonical '.$this->argument('canonical').' deactivated');
            } else {
                $canonical->update(['is_crawling_prices' => true]);
                $this->info('Canonical '.$this->argument('canonical').' activated');
            }
        } else {
            throw new \Exception('Canonical doesnt exist');
        }

        return 0;
    }
}
