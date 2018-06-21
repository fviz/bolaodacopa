<?php

namespace App\Http\Controllers;

use App\Bet;
use App\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BetController extends Controller
{
    public function add(Request $request) {
		$game_id = $request->game_id;

		$this_game = Game::find($game_id);

		if (time() < strtotime($this_game->date)) {
			if (Auth::check()) {
				$bet = new Bet;

				$bet->aScore = $request->a;
				$bet->bScore = $request->b;
				$bet->usu_id = Auth::id();
				$bet->game_id = $game_id;

				$bet->save();
			} else {
				return response("User not authenticated.", 500);
			}
		} else {
			return response("O jogo já começou.", 500);
		}


    }

    public function edit(Bet $bet, Request $request) {
	    if (gmdate("U") * 1000 < $bet->game->date) {
		    $bet->aScore = $request->a;
		    $bet->bScore = $request->b;
		    $bet->save();
	    }

    }
}
