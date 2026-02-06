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
 Schema::create('order_items', function (Blueprint $table) {
            $table->id('id_order_item');

            $table->unsignedBigInteger('id_order');
            $table->unsignedBigInteger('id_produit');

            $table->integer('quantity');
            $table->decimal('price', 10, 2); // price وقت الطلب

            $table->timestamps();

            // FK order
            $table->foreign('id_order')
                ->references('id_order')
                ->on('orders')
                ->cascadeOnDelete();

            // FK product
            $table->foreign('id_produit')
                ->references('id_produit')
                ->on('produits')
                ->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
