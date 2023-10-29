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
            $table->string('nama_paket');
            $table->string('vendor');
            $table->integer('jtm');
            $table->integer('jtr');
            $table->string('gardu');
            $table->integer('progres');
            $table->string('pengawas_k3');
            $table->string('koordinat');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
