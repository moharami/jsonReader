<?php

namespace App\Jobs;

use App\Models\CreditCard;
use App\Models\User;
use http\Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class DataEntry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var mixed
     */
    private $users;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $content = file_get_contents(storage_path('challenge.json'));
        $users = json_decode($content, true);
        
        foreach ($users as $key => $user) {
            DB::transaction(function () use ($user) {
                $credit_card = new CreditCard($user['credit_card']);
                $user = User::create($user);
                $user->CreditCard()->save($credit_card);
            });
        }
    }
}
