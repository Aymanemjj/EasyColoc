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
        Schema::create('payment_pending', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->float('amount');
            $table->boolean('status')->default(false);
            $table->date('payment_date')->default(null);
            $table->foreignId('user_id')->constrained();
            $table->foreignId('expence_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments_pending');
    }
};
