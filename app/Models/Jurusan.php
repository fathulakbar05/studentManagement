<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan';
    protected $primaryKey = 'jurusan_id';

    public function prodis()
    {
        return $this->hasMany(Prodi::class);
    }

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id', 'fakultas_id');
    }
}
