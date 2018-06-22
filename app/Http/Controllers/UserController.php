<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function edit(Request $request) {
	    $passtry = User::where('password', $request->pin)->first();
	    $user = Auth::user();
	    if ($user == $passtry) {
		    return redirect('/profile/' . $user->id);
	    } elseif ($passtry === null) {
		    $user->name = $request->name;
		    $user->password = $request->pin;
		    $user->save();
		    return redirect('/profile/' . $user->id);
	    } else {
		    return view('error', ['error' => "PIN não disponível."]);
	    }
    }
}
