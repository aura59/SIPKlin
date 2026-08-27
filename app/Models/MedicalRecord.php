<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $table = 'rekam_medis';

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'tanggal',
        'diagnosis',
        'treatment',
        'catatan'
    ];
    
    public function registration()
    {
        return $this->belongsTo(Registration::class, 'pendaftaran_id');
    }
}
