<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function edit(Request $request) {
		$user = Auth::user();
		$user->name = $request->name;
		$user->password = $request->pin;
		$user->save();

		return redirect('/profile/' . $user->id);
    }
}
