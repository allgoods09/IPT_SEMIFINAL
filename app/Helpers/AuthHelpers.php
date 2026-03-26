<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class AuthHelpers {

    public static function isLoggedIn(): bool {
        return Auth::check();
    }

    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            redirect()->route('login')->send();
        }
    }

    public static function requireAdmin() {
        self::requireLogin();
        if (strtolower(Auth::user()->role) !== 'admin') {
            redirect()->route('dashboard')->with('error', 'Unauthorized')->send();
        }
    }

    public static function isAdmin(): bool {
        return self::isLoggedIn() && strtolower(Auth::user()->role) === 'admin';
    }

    public static function currentUser() {
        if (!self::isLoggedIn()) return null;
        return [
            'id'   => Auth::id(),
            'name' => Auth::user()->name,
            'role' => Auth::user()->role,
        ];
    }
}