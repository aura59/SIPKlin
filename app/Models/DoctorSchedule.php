<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    protected $table = 'doctor_schedules';

    protected $fillable = [
        'doctor_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'kuota'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function registration()
    {
        return $this->hasMany(Registration::class, 'doctor_schedule_id');
    }

}
