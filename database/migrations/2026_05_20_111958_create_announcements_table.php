<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            // Menghubungkan pengumuman dengan admin yang membuatnya
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->string('title');
            $table->text('content');
            $table->json('type'); // Menyimpan array tipe/genre pengumuman (URGENT, TUGAS, dll)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};