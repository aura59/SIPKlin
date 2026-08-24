<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = 'dokter';

    protected $fillable = [
        'user_id',
        'poli_id',
        'nama',
        'spesialis',
        'no_telepon',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function jadwal()
    {
        return $this->hasMany(JadwalDokter::class);
    }
}
