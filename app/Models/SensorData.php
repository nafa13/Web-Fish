<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorData extends Model
{
    use HasFactory;

    // Arahkan ke tabel yang benar
    protected $table = 'sensor_suhu'; 

    public $timestamps = false;

    // Sesuaikan dengan kolom yang kamu sebutkan tadi
    protected $fillable = [
        'nilai', // Ini yang berisi data suhu
        'waktu'
    ];
}