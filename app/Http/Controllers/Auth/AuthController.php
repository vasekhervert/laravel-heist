<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        auth()->login($user);
        
        return redirect()->route('dashboard')
            ->with('success', 'Úspěšně jste se zaregistrovali a přihlásili');
    }

    public function registerWeb(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        auth()->login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Úspěšně jste se zaregistrovali a přihlásili');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            $user = User::where('google_id', $googleUser->id)->first();
            
            if (!$user) {
                $user = User::where('email', $googleUser->email)->first();
                
                if ($user) {
                    $user->google_id = $googleUser->id;
                    $user->save();
                } else {
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'password' => Hash::make(Str::random(16))
                    ]);
                }
            }

            return redirect('/login-user/' . $user->id);

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Přihlášení přes Google selhalo: ' . $e->getMessage());
        }
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')
            ->scopes(['email', 'public_profile'])
            ->stateless()
            ->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->user();
            
            $user = User::where('facebook_id', $facebookUser->id)->first();
            
            if (!$user) {
                $user = User::where('email', $facebookUser->email)->first();
                
                if ($user) {
                    $user->facebook_id = $facebookUser->id;
                    $user->save();
                } else {
                    $user = User::create([
                        'name' => $facebookUser->name,
                        'email' => $facebookUser->email,
                        'facebook_id' => $facebookUser->id,
                        'password' => Hash::make(Str::random(16))
                    ]);
                }
            }

            return redirect('/login-user/' . $user->id);

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Přihlášení přes Facebook selhalo: ' . $e->getMessage());
        }
    }

    public function webLogout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function loginWithEmail(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard')
                ->with('success', 'Úspěšně jste se přihlásili');
        }

        return back()->withErrors([
            'email' => 'Zadané přihlašovací údaje jsou nesprávné.',
        ])->withInput($request->except('password'));
    }

    public function showRegistrationForm()
    {
        return view('register');
    }
}
