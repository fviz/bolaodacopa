<?php

namespace App\Http\Controllers;

use App\Bet;
use App\Country;
use App\Game;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{

    public function check() {
	    if (Auth::check()) {
		    $games = Game::get();
		    $countries = Country::get();
		    $users = DB::table('users')->orderBy('score', 'desc')->get();
		    return view('index', ['games' => $games, 'countries' => $countries, 'users' => $users]);
	    } else {
	    	return view('login');
	    }
    }

    public function profile(User $user) {
    	return view('profile', ['tuser' => $user]);
    }

	public function profileEdit() {
		return view('profileEdit');
	}

    public function newbet(Game $game) {
	    $countries = Country::get();
	    return view('newbet', ['game' => $game, 'countries' => $countries]);
    }

    public function betedit(Bet $bet) {
	    $countries = Country::get();
	    return view('editbet', ['bet' => $bet, 'countries' => $countries]);
    }

}
