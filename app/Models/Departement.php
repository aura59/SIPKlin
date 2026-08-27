<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $table = 'departement';

    protected $fillable = [
        'nama_poli',
        'deskripsi'
    ];

    public function doctor()
    {
        return $this->hasMany(Doctor::class);
    }
}
