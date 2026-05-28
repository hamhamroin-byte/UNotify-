<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // Kolom Hak Akses: Defaultnya adalah 'user' (mahasiswa), bisa diubah jadi 'admin'
            $table->string('role')->default('user'); 
            
            // Kolom Fitur Blokir: 'active' artinya normal, 'blocked' artinya tidak bisa login/akses
            $table->string('status')->default('active'); 

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};