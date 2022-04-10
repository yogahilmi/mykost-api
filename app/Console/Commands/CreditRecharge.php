<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreditRecharge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:recharge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scheduled command to recharge user credit on every start of the month';

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
        $users = User::where('role', 1)->update(['credit' => 20]);
        $users = User::where('role', 2)->update(['credit' => 40]);

        $this->info('Execute the command to recharge the credit successfully');
    }
}
