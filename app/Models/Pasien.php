<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';

    protected $fillable = [
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_telepon'
    ];

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'pasien_id');
    }
}
