<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id_categorie';

    protected $fillable = [
        'name_categorie',
        'is_active',
    ];
    public function produits()
    {
        return $this->hasMany(Produit::class, 'id_categorie', 'id_categorie');
    }
}
