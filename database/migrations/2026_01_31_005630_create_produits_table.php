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
        Schema::create('produits', function (Blueprint $table) {
            $table->id('id_produit');

            // Categorie optionnelle    
            $table->unsignedBigInteger('id_categorie')->nullable();

            $table->string('name_produit');
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->decimal('price', 10, 2);

            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('id_categorie')
                ->references('id_categorie')
                ->on('categories')
                ->nullOnDelete(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
