<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Universitas extends Model
{
    use HasFactory;

    // Tentukan nama tabel
    protected $table = 'universitas';

    // Tentukan primary key
    protected $primaryKey = 'id_universitas';

    // Mass assignable attributes
    protected $fillable = [
        'nama_universitas',
        'akreditasi',
        'lokasi',
        'website',
    ];
}
