<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Karyawan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Halaman Login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses Login
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // ==========================
        // LOGIN ADMIN
        // ==========================
        if ($user->isAdmin()) {
            return redirect()->route('dashboard');
        }

        // ==========================
        // LOGIN KARYAWAN
        // ==========================
        $karyawan = Karyawan::where('user_id', $user->id)->first();

        if (!$karyawan) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Data karyawan tidak ditemukan.',
            ]);
        }

        if ($karyawan->status === Karyawan::STATUS_DITOLAK) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Pendaftaran akun Anda ditolak oleh Administrator.',
            ]);
        }

        if ($karyawan->status === Karyawan::STATUS_NONAKTIF) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akun Anda dinonaktifkan.',
            ]);
        }

        if (!$karyawan->isUsable()) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akun Anda belum diverifikasi oleh Administrator.',
            ]);
        }

        return redirect()->route('dashboard.karyawan');
    }

    /**
     * Logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
