<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usu extends Model
{


	public function bets() {
		return $this->hasMany('App\Bet');
	}
}
