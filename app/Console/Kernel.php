<?php

namespace App\Console;

use App\Bet;
use App\Country;
use App\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel {

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
	 * @param  \Illuminate\Console\Scheduling\Schedule $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule) {
		$schedule->call(function () {

			$unprocessed = Bet::where('processed', 0)->get();
			foreach ($unprocessed as $bet)
			{
				if ($bet->game->isDone())
				{
					$trueAScore = $bet->game->teamAscore;
					$trueBScore = $bet->game->teamBscore;
					$betAScore = $bet->aScore;
					$betBScore = $bet->bScore;
					$rule = $bet->game->rule;

					$points = $this->process($trueAScore, $trueBScore, $betAScore, $betBScore, $rule);

					$bet->user->score += $points;
					$bet->user->save();
					$bet->processed = true;
					$bet->pointsreceived = $points;
					$bet->save();

					// LOG
					$messageTemplate = '%s + %d ponto(s). Jogo: %s (%d) vs %s (%d). Aposta: %d : %d.';
					$message = sprintf($messageTemplate, $bet->user->name, $bet->pointsreceived, $bet->game->teamA, $bet->game->teamAscore, $bet->game->teamBscore, $bet->aScore, $bet->bScore);
					Log::channel('bolao')->info($message);
				}
			}

		})->everyMinute();
	}

	/**
	 * Register the commands for the application.
	 *
	 * @return void
	 */
	protected function commands() {
		$this->load(__DIR__ . '/Commands');

		require base_path('routes/console.php');
	}

	protected static function process($tascore, $tbscore, $bascore, $bbscore, $rule) {

		// Fase de grupos
		if ($rule == 1)
		{

			// Placar exato
			if ($tascore == $bascore && $tbscore == $bbscore)
			{

				return 3;
				// Time vitorioso
			} else if (($tascore > $tbscore && $bascore > $bbscore) || ($tascore < $tbscore && $bascore < $bbscore))
			{
				return 1;
				// Empate
			} else if ($tascore == $tbscore && $bascore == $bbscore)
			{
				return 1;
			} else
			{
				return 0;
			}

		}


	}
}
