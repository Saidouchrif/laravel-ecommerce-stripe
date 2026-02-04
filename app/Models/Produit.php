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

    protected $casts = [
        'color' => 'array',
    ];

    // Accessor to handle legacy single string values
    public function getColorAttribute($value)
    {
        if (empty($value)) {
            return [];
        }
        
        // Check if it's a JSON string (new format) or plain string (legacy format)
        $decoded = json_decode($value, true);
        
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }
        
        // Legacy format: single string value
        return [$value];
    }

    // Mutator to store array as JSON string
    public function setColorAttribute($value)
    {
        if (is_null($value) || (is_array($value) && empty(array_filter($value)))) {
            $this->attributes['color'] = null;
            return;
        }

        if (is_array($value)) {
            // Filter out empty values
            $filteredValue = array_filter($value, function($item) {
                return !empty(trim($item));
            });
            
            if (empty($filteredValue)) {
                $this->attributes['color'] = null;
                return;
            }
            
            $this->attributes['color'] = json_encode($filteredValue);
        } else {
            $this->attributes['color'] = json_encode([$value]);
        }
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie', 'id_categorie');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'id_produit', 'id_produit');
    }
}
