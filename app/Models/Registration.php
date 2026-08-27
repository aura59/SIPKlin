<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = 'pendaftaran';

    protected $fillable = [
        'pasien_id',
        'doctor_schedule_id',
        'tanggal',
        'keluhan',
        'catatan',
        'status'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'pasien_id');
    }

    public function doctorSchedule()
    {
        return $this->belongsTo(DoctorSchedule::class, 'doctor_schedule_id');
    }

    public function queue()
    {
        return $this->hasOne(Queue::class, 'pendaftaran_id');
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord ::class, 'pendaftaran_id');
    }   
}
