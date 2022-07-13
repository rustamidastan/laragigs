<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function register() {
        return view('user.register');
    }

    public function login() {
        return view('user.login');
    }

    public function store(Request $request) {
        $userFiled = $request -> validate([
            'name'=>['required', 'min:3'],
            'email'=>['required','email', Rule::unique('users', 'email')],
            'password'=>['required','confirmed','min:6'],
        ]);

        $userFiled['password'] = bcrypt($userFiled['password']);

        $user = User::create($userFiled);

        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in!');
    }

    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out');
    }

    public function authenticate(Request $request) {
        $userFiled = $request -> validate([
            'email'=>['required','email'],
            'password'=>'required',
        ]);

        if(auth()->attempt($userFiled)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You are now logged in!');
        }
        
        return back()->withErrors(['email'=>'Invalid Credentials'])->onlyInput('email');
    }
}
