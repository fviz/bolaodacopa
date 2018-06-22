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

	// Check if user is logged in
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

    public function apitest() {
//    	return view('apitest');
	    $json = file_get_contents('https://api.fifa.com/api/v1/calendar/matches?idseason=254645&idcompetition=17&language=en-GB&count=100');
	    $obj = json_decode($json);
	    dd($obj->Results);
//	    dd($obj->Results[23]->Home->TeamName[0]->Description);
    }

}
