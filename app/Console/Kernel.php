<?php

namespace App\Console;

use App\Bet;
use App\Game;
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

			Log::channel('bolao')->info("\r\n \r\n============ Start Fifa API check ============");
			$json = file_get_contents('https://api.fifa.com/api/v1/calendar/matches?idseason=254645&idcompetition=17&language=en-GB&count=100');
			$obj = json_decode($json);


			foreach (Game::all() as $game)
			{
				if ( ! $game->isDone())
				{

					$fifa_game = $obj->Results[$game->id];
					$fifa_match_status = $fifa_game->MatchStatus;

					// Check scores
					Log::channel('bolao')->info("Step 1/2 - Game Scores");
					if ($fifa_match_status == 3)
					{
						Log::channel('bolao')->info("   -> Game " . $game->teamA . " vs " . $game->teamB . " -> New Score -> " . $fifa_game->HomeTeamScore . " : " . $fifa_game->AwayTeamScore . "");
						$game->teamAscore = $fifa_game->HomeTeamScore;
						$game->teamBscore = $fifa_game->AwayTeamScore;
						$game->save();

						Log::channel('bolao')->info("\r\nFinished checking scores.");
					} else {
						Log::channel('bolao')->info("   -> Game " . $game->teamA . " vs " . $game->teamB . " -> Game is not on. Won't check score.");
					}


					// Check if games are done
					Log::channel('bolao')->info("Step 2/2 - Game Status");
					Log::channel('bolao')->info("   -> Game: " . $game->teamA . " vs " . $game->teamB . "");
					if ($fifa_match_status == 0)
					{
						$game->finished = 1;
						$game->save();
						Log::channel('bolao')->info("      Finished. DB updated");
					} else
					{
						Log::channel('bolao')->info("      Not finished.");
					}
				}
			}

			Log::channel('bolao')->info("\r\n---");


			// Process bets
			Log::channel('bolao')->info("== Start Bet check ==");
			$number_of_bets_processed = 0;

			$unprocessed = Bet::where('processed', 0)->get();
			Log::channel('bolao')->info("Unprocessed bets found: " . count($unprocessed) . ".");
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
					$number_of_bets_processed++;
					$messageTemplate = '%s + %d ponto(s). Jogo: %s (%d) vs %s (%d). Aposta: %d : %d.';
					$message = sprintf($messageTemplate, $bet->user->name, $bet->pointsreceived, $bet->game->teamA, $bet->game->teamAscore, $bet->game->teamB, $bet->game->teamBscore, $bet->aScore, $bet->bScore);
					Log::channel('bolao')->info($message);
				}
			}

			Log::channel('bolao')->info("Bets processed: " . $number_of_bets_processed . ".");
			Log::channel('bolao')->info("Stop bet check. \r\n");
			Log::channel('bolao')->info("Script finished. \r\n\r\n");

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
