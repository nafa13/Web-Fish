<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    // 1. Beritahu nama tabel yang benar (sesuai gambar Anda)
    protected $table = 'jadwal'; 

    // 2. Karena di gambar tidak ada kolom 'created_at' & 'updated_at', matikan timestamps
    public $timestamps = false;

    // 3. Daftarkan kolom yang boleh diedit
    protected $fillable = [
        'jenis_jadwal',
        'waktu',
        'aktif',
    ];
}