<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $table = 'medical_records';

    protected $fillable = [
        'registration_id',
        'keluhan',
        'diagnosis',
        'tindakan',
    ];
    
    public function registration()
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }
}
