<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    // KUNCI UTAMA: Semua kolom ini WAJIB didaftarkan agar bisa disimpan lewat ::create()
 protected $fillable = [
    'title',
    'content',
    'type',
    'target_class',
    'user_id',
    'attachment', // Pastikan ini ditambahkan
];

    protected $casts = [
        'type' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}   