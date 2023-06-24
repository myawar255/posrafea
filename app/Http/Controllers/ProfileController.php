<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;

class ProfileController extends Controller
{
    public function updatePassword(Request $request) {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'password' => ['required', 'confirmed'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> bcrypt($request->password)]);

        $request->session()->flash('success');

        return redirect(route('users.edit.password'));
    }
}
