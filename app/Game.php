<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

	public function bets() {
		return $this->hasMany('App\Bet');
	}

}