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
        Schema::create('itemset3', function (Blueprint $table) {
            $table->id();
            $table->string('atribut');
            $table->double('support');
            $table->string('keterangan');
            $table->foreignId('proses_id')->constrained('proses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itemset3');
    }
};
