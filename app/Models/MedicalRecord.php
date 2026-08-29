<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $table = 'medical_records';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'tanggal',
        'diagnosis',
        'treatment',
        'catatan'
    ];
    
    public function registration()
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }
}
