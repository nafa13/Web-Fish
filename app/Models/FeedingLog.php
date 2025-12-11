<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedingLog extends Model
{
    use HasFactory;

    // Tambahkan ini agar data bisa disimpan via Controller
    protected $fillable = [
        'fed_at',
        'status',
        'type',
        'user_id',
    ];

    // Relasi ke User (opsional, biar tahu siapa yang memberi makan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}