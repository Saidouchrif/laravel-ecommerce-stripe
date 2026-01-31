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
        Schema::create('product_images', function (Blueprint $table) {
           $table->id('id_image');

            $table->unsignedBigInteger('id_produit');

            $table->string('image_path');
            $table->timestamps();

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
        Schema::dropIfExists('product_images');
    }
};
