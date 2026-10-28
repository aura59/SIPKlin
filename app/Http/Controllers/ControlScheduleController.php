<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use Carbon\Carbon;

class ControlScheduleController extends Controller
{
     public function index()
    {
        $jadwalKontrol = MedicalRecord::with([
            'registration.patient',
            'registration.doctorSchedule.doctor.department',
        ])
        ->where('perlu_kontrol', true)
        ->whereNotNull('tanggal_kontrol')
        ->whereDate('tanggal_kontrol', '>=', Carbon::today()->toDateString())
        ->orderBy('tanggal_kontrol', 'asc')
        ->get();

        return view('pages.control-schedules.index', compact('jadwalKontrol'));
    }
}
