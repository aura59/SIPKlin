<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';

    protected $fillable = [
        'pasien_id',
        'jadwal_dokter_id',
        'tanggal',
        'keluhan',
        'catatan',
        'status'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function jadwalDokter()
    {
        return $this->belongsTo(JadwalDokter::class, 'jadwal_dokter_id');
    }

    public function antrean()
    {
        return $this->hasOne(Antrean::class, 'pendaftaran_id');
    }

    public function rekamMedis()
    {
        return $this->hasOne(RekamMedis::class, 'pendaftaran_id');
    }   
}
