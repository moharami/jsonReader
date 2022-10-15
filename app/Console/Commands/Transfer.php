<?php

namespace App\Console\Commands;

use App\Jobs\DataEntry;
use App\Models\User;
use App\Sterategy\Pointer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

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

    protected $line = '-----------------------------';

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

        $this->migrateFresh();
        $this->addJob();
        $this->runJob();
        $this->info('Finished');
    }

    protected function migrateFresh(): void
    {
        $this->line($this->line);
        if ($this->confirm('Do you want Fresh Migrate and reset pointer')) {
            $this->info('Step : Fresh Migrate Dabatabse ');
            $this->line($this->line);
            $this->call('migrate:fresh');
            Pointer::resetPointer();
            $this->line($this->line);
        }
    }

    protected function addJob(): void
    {
        $file = 'challenge.json';
        $this->info($file);
        $this->line($this->line);
        $this->info('Step : Added DataEntry Job ');
        $this->line($this->line);
        DataEntry::dispatch($file);
    }

    protected function runJob(): void
    {
        if ($this->confirm('Do you Want To Run Queue')) {
            $this->line($this->line);
            $this->call('queue:work');
        } else {
            $this->info('Step : Run `php artisan queue:work`');
        }
    }

}
