<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'dokter';

    protected $fillable = [
        'user_id',
        'departement_id',
        'nama',
        'spesialis',
        'no_telepon',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function jadwal()
    {
        return $this->hasMany(DoctorSchedule::class);
    }
}
