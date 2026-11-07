<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MedicalRecord;
use App\Models\User;

class ControlScheduleHistory extends Model
{
    protected $table = 'control_schedule_histories';

    protected $fillable = [
        'medical_record_id',
        'tanggal_kontrol_lama',
        'catatan_kontrol_lama',
        'tanggal_kontrol_baru',
        'catatan_kontrol_baru',
        'user_id',
    ];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
