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
        Schema::create('kategori_buku_relasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buku_id');
            $table->unsignedBigInteger('kategori_id');

            $table->index(['buku_id', 'kategori_id']);

            $table->foreign('buku_id')->references('id')->on('buku');
            $table->foreign('kategori_id')->references('id')->on('kategori_buku');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategori_buku_relasi', function (Blueprint $table) {
            $table->dropConstrainedForeignId('buku_id');
            $table->dropConstrainedForeignId('kategori_id');
        });

        Schema::dropIfExists('kategori_buku_relasi');
    }
};
