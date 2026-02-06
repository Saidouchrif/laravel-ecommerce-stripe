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
            $table->id('id_order');

            $table->unsignedBigInteger('id_user');

            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');

            // Payment
            $table->enum('payment_method', ['cash', 'online']);
            $table->enum('payment_status', ['pending', 'paid'])->default('pending');

            // Validation commande
            $table->boolean('is_validated')->default(false);

            // Total
            $table->decimal('total_amount', 10, 2);

            $table->timestamps();

            // Foreign key user
            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
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
