<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //

    public function index()
    {
        return view('login.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard.index');
        } else {
            return redirect()->back()->with('incorreto', 'Email ou senha incorreta');
        }
    }

    public function cadastrar(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials['password'] = bcrypt($credentials['password']);

        $user = User::firstOrNew(['email' => $credentials['email']], [
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ]);

        if ($user->exists === false) {
            $user->save();
        } else {
            return redirect()->back()->with('userExists', true);
        }

        return redirect()->back()->with('userExists', false);
    }
}
