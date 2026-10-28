<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\MedicalRecord;
use Carbon\Carbon;

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
        View::composer('layouts.inc.navbar', function ($view) {
            $jadwalKontrolNotifikasi = MedicalRecord::with([
                'registration.patient',
                'registration.doctorSchedule.doctor.department',
            ])
                ->where('perlu_kontrol', true)
                ->whereNotNull('tanggal_kontrol')
                ->whereDate('tanggal_kontrol', '>=', Carbon::today()->toDateString())
                ->orderBy('tanggal_kontrol', 'asc')
                ->take(5)
                ->get();

            $jumlahJadwalKontrol = MedicalRecord::where('perlu_kontrol', true)
                ->whereNotNull('tanggal_kontrol')
                ->whereDate('tanggal_kontrol', '>=', Carbon::today()->toDateString())
                ->count();

            $view->with([
                'jadwalKontrolNotifikasi' => $jadwalKontrolNotifikasi,
                'jumlahJadwalKontrol' => $jumlahJadwalKontrol,
            ]);
        });
    }
}
