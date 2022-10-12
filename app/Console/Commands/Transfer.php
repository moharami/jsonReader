<?php

namespace App\Console\Commands;

use App\Jobs\DataEntry;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Transfer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transfer json file Into Mysql Database';

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
        $line = '-----------------------------';
        $this->line($line);
        $this->info('Step 1: Fresh Migrate Dabatabse ');
        $this->line($line);
        $this->call('migrate:fresh');

        $this->line($line);
        $this->info('Step 2: Added DataEntry Job ');
        $this->line($line);
        DataEntry::dispatch();


        $this->line($line);
        $this->info('Step 3: Run Queue Worker');
        $this->line($line);
        $this->call('queue:work');
        $this->info('Transfer Finished');

    }
}
