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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_phone');
            $table->text('address')->nullable();
            $table->text('observation')->nullable();
            $table->boolean('pickup_in_store')->default(0);
            $table->decimal('total_value', 8, 2);
            $table->decimal('delivery_fee', 8, 2)->default(0);
            $table->string('payment_type');
            $table->decimal('change_to', 8, 2)->nullable();
            $table->foreignId('status_id')->constrained('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
