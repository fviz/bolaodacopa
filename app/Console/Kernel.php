<?php

namespace App\Console;

use App\Bet;
use App\Country;
use App\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
    	$schedule->call(function(){

    		$unprocessed = Bet::where('processed', 0)->get();
    		foreach($unprocessed as $bet) {
    			if($bet->game->isDone()) {
    				$trueAScore = $bet->game->teamAScore;
    				$trueBScore = $bet->game->teamBScore;
    				$betAScore = $bet->aScore;
    				$betBScore = $bet->bScore;
    				$rule = $bet->game->rule;

    				$this->processScore($trueAScore, $trueBScore, $betAScore, $betBScore, $rule);

    				$bet->processed = true;
    				$bet->save();
			    }
		    }

	    })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    private function processScore() {

    }
}
