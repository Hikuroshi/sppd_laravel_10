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
        Schema::create('uang_penginapans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('keterangan');
            $table->string('slug')->unique();
            $table->integer('eselon_i');
            $table->integer('eselon_ii');
            $table->integer('eselon_iii');
            $table->integer('eselon_iv');
            $table->integer('golongan_iv');
            $table->integer('golongan_iii');
            $table->integer('golongan_ii');
            $table->integer('golongan_i');
            $table->unsignedBigInteger('wilayah_id');
            $table->string('wilayah_type');
            $table->unsignedBigInteger('author_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uang_penginapans');
    }
};
