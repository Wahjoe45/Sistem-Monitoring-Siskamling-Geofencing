
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkpoints', function (Blueprint $table) {
            $table->id('id_checkpoint');
            $table->unsignedBigInteger('id_warga');
            $table->unsignedBigInteger('id_pos');
            $table->string('nama');
            $table->string('namaPos');
            $table->string('foto');
            $table->decimal('latitude_user', 10, 8);
            $table->decimal('longitude_user', 11, 8);
            $table->decimal('jarak_meter', 10, 3);
            $table->enum('status_validasi', [
                'valid',
                'invalid'
            ]);

            $table->timestamps();
            $table->foreign('id_warga')
                ->references('id_warga')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('id_pos')
                ->references('id_pos')
                ->on('posjagas')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkpoints');
    }
};
