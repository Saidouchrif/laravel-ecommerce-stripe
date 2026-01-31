<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $table = 'produits';
    protected $primaryKey = 'id_produit';

    protected $fillable = [
        'id_categorie',
        'name_produit',
        'description',
        'color',
        'price',
        'is_active',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie', 'id_categorie');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'id_produit', 'id_produit');
    }
}
