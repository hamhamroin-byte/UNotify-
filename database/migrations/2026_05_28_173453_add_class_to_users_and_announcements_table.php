<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom class di tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->string('class')->nullable()->after('role'); // nullable karena admin tidak punya kelas
        });

        // Tambah kolom target_class di tabel announcements
        Schema::table('announcements', function (Blueprint $table) {
            $table->string('target_class')->after('type'); // Menyimpan info kelas mana yang dituju
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('class');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn('target_class');
        });
    }
};