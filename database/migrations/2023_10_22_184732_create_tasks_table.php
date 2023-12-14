<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('nama_paket');
            $table->float('target_jtm');
            $table->integer('nilai_kontrak_jtm');
            $table->float('target_jtr');
            $table->integer('nilai_kontrak_jtr');
            $table->float('target_gardu');
            $table->integer('nilai_kontrak_gardu');
            $table->integer('ongkos_angkut');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
