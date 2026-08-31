<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index() {
        $titulo = "Inicio de Sesión";
        return view("modules.auth.login", compact("titulo"));
    }

    public function login(Request $request) {
        $credenciales = $request->validate([ 'email' => 'required|email', 'password'=> 'required', ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['email' => 'Credenciales invalidas.'])
                ->withInput();
        }

        if (!$user->is_active) {
            return back()
                ->withErrors(['email' => 'Tu cuenta está inactiva.'])
                ->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();

        return to_route('home');
    }

    public function crearAdmin() {
        User::create([
            'name' => 'Eliexer', 
            'email' => 'admin@admin.com',
            'password' => Hash::make('12341234'),
            'is_active' => true,
            'roles' => 'admin',
        ]);

        return "Usuario admin creado exitosamente";
    }

    public function logout() {
        Auth::logout();
        return to_route("login");
    }
}
