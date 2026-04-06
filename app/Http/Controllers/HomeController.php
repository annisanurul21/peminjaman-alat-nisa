<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware; // Tambahkan ini
use Illuminate\Routing\Controllers\Middleware;    // Tambahkan ini

class HomeController extends Controller implements HasMiddleware // Tambahkan implements
{
    /**
     * Daftarkan middleware di sini (Cara Laravel Terbaru)
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function index()
    {
        return view('home');
    }
}