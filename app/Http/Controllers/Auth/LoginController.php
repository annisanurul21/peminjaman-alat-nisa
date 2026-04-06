<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Controllers\HasMiddleware; // Tambahkan ini
use Illuminate\Routing\Controllers\Middleware;    // Tambahkan ini

class LoginController extends Controller implements HasMiddleware
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Cara Baru Laravel 12 Mengatur Middleware
     */
    public static function middleware(): array
    {
        return [
            // Middleware guest agar yang sudah login tidak bisa buka halaman login lagi
            // kecuali untuk method 'logout'
            new Middleware('guest', except: ['logout']),
        ];
    }
}