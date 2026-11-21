<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwal_details', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_jadwal');
            $table->unsignedBigInteger('id_warga');
            $table->date('tanggal');
            $table->foreign('id_jadwal')
                  ->references('id_jadwal')
                  ->on('jadwals')
                  ->onDelete('cascade');

            $table ->foreign('id_warga')
                   ->references('id_warga')
                   ->on('users')
                   ->onDelete('cascade');
            $table->unique(['id_jadwal', 'id_warga']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_details');
    }
};
