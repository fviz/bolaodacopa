<?php

namespace App\Console;

use App\Bet;
use App\Country;
use App\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

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
    				$trueAScore = $bet->game->teamAscore;
    				$trueBScore = $bet->game->teamBscore;
    				$betAScore = $bet->aScore;
    				$betBScore = $bet->bScore;
    				$rule = $bet->game->rule;

    				$points = $this->processScore($trueAScore, $trueBScore, $betAScore, $betBScore, $rule);
    				Log::debug($points);


    				$bet->user->score += $points;
    				$bet->user->save();
    				$bet->processed = true;
				    $bet->pointsreceived = $points;
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

    function processScore($tascore, $tbscore, $bascore, $bbscore, $rule) {

	    // Fase de grupos
	    if ($rule == 1) {

		    // Placar exato
		    if ($tascore == $bascore && $tbscore == $bbscore) {
			    return 3;
			    // Time vitorioso
		    } else if (($tascore > $tbscore && $bascore > $bbscore) || ($tascore < $tbscore && $bascore < $bbscore)) {
			    return 1;
			    // Empate
		    } else if ($tascore == $tbscore && $bascore == $bbscore) {
			    return 1;
		    }

	    }
    }
}
