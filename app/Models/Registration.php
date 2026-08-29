<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = 'registrations';

    protected $fillable = [
        'patient_id',
        'doctor_schedule_id',
        'tanggal',
        'keluhan',
        'catatan',
        'status'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctorSchedule()
    {
        return $this->belongsTo(DoctorSchedule::class, 'doctor_schedule_id');
    }

    public function queue()
    {
        return $this->hasOne(Queue::class, 'registration_id');
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord ::class, 'registration_id');
    }   
}
