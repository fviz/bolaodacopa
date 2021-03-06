<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

	public function edit(Request $request) {
		$passtry = User::where('password', $request->pin)->first();
		$user = Auth::user();

		if ($passtry === null)
		{
			$user->password = $request->pin;
			$user->name = $request->name;
			$user->save();
			return redirect('/profile/' . $user->id);
		} else
		{
			if ($user->id == $passtry->id)
			{
				$user->name = $request->name;
				$user->save();

				return redirect('/profile/' . $user->id);
			}
			return view('error', ['error' => "PIN não disponível."]);
		}
	}
}
