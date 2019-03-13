<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\UserController;

class Fbscheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fbscheduler {function}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule the deletion of Firebase data';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $function = $this->argument('function');
        $this->line("Executing ".$function." functions");
        if($function === 'test') {
            $time = UserController::TestAlvin();
            $this->line($time);
        }
        else if($function === 'add') {
            $add = UserController::AddToCleanFirebaseQue();
            $this->line($add);
        }
        else if($function === 'execute') {
            $this->line("Working..");
            $execute = UserController::scheduleFeedCleaning();
            $this->line($execute);
        }
        else if($function === 'hello') {
            $this->line("Hello");
        }
        
    }
    
    
}
