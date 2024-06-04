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
        Schema::create('confidence', function (Blueprint $table) {
            $table->id();
            $table->string('items');
            $table->double('support_xUy');
            $table->double('support_x');
            $table->double('confidence');
            $table->double('lift_ratio');
            $table->string('korelasi');
            $table->foreignId('itemset2_id')->nullable()->constrained('itemset2')->onDelete('cascade');
            $table->foreignId('itemset3_id')->nullable()->constrained('itemset3')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('confidence');
    }
};
