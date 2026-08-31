<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'nama_department',
        'deskripsi',
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'department_id');
    }
}