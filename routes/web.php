<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Game;
use App\Country;
use App\User;
use App\Usu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', 'PageController@check');

Route::get('/games/{game}', 'PageController@newbet');

Route::post('/bets/add', "BetController@add");
Route::get('/bets/{bet}', 'PageController@betedit');
Route::post('/bets/edit/{bet}', 'BetController@edit');

Route::get('/logout', function() {
	Auth::logout();
	return redirect()->intended('/');
});

Route::get('/profile/{user}', 'PageController@profile');

Route::post('/login', function(Request $request) {
	if ($user = User::select('id')->where('password',$request->pin)->first())
	{
		Auth::loginUsingId($user->id);

		return redirect()->intended('/');
	} else {
		return view('login', ['message' => 'PIN não encontrado']);
	}
});