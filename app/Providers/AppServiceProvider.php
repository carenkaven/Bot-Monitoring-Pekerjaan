<?php

namespace App\Providers;

use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bagikan data notifikasi (laporan menunggu verifikasi) ke navbar.
        // Hanya untuk admin — karyawan tidak punya akses verifikasi.
        View::composer('layouts.navbar', function ($view) {
            $notifLaporans = collect();
            $notifCount = 0;

            if (Auth::check() && Auth::user()->isAdmin()) {
                $notifLaporans = Laporan::menunggu()
                    ->with('karyawan')
                    ->latest('tanggal')
                    ->take(5)
                    ->get();

                $notifCount = Laporan::menunggu()->count();
            }

            $view->with([
                'notifLaporans' => $notifLaporans,
                'notifCount' => $notifCount,
            ]);
        });
    }
}
