<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        Auth::login($user);

        return $this->redirectBasedOnRole($user);
    }

    private function redirectBasedOnRole(User $user)
    {
        return redirect()->route($user->role === 'admin' ? 'admin.dashboard' : 'home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function showAdminRegistrationForm()
    {
        return view('auth.register_admin');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $request->validate([
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'id_card_type' => 'required|string|in:KTP,SIM,Passport',
            'id_card_number' => 'required|string|min:8|max:16',
        ]);

        $guest = Guest::create([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'id_card_type' => $request->id_card_type,
            'id_card_number' => $request->id_card_number
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guest',
        ]);

        Auth::login($user);

        return $this->redirectBasedOnRole($user);
    }

    public function registerAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        Auth::login($user);

        return $this->redirectBasedOnRole($user);
    }
}