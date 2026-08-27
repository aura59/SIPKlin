<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $table = 'antrean';

    protected $fillable = [
        'pendaftaran_id',
        'nomor_antrean',
        'status'
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class, 'pendaftaran_id');
    }
}
