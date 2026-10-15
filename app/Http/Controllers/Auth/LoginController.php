<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión administrativo.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Procesa la autenticación del administrador por 'username' y 'password'.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'El campo usuario es obligatorio.',
            'password.required' => 'El campo contraseña es obligatorio.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Sesión iniciada correctamente. Bienvenido al panel SaaS.');
        }

        return back()->withErrors([
            'username' => 'El usuario o la contraseña son incorrectos.',
        ])->onlyInput('username');
    }

    /**
     * Cierra la sesión activa y redirige a la Landing Page.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Has cerrado sesión correctamente.');
    }
}
