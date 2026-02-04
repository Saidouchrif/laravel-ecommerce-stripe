<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_produit' => 'required|exists:produits,id_produit',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'required|array|min:1',
        ]);

        $uploadedImages = [];
        
        foreach ($request->file('images') as $image) {
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/produits'), $filename);
            
            $productImage = ProductImage::create([
                'id_produit' => $request->id_produit,
                'image_path' => 'images/produits/' . $filename,
            ]);
            
            $uploadedImages[] = $productImage;
        }

        return response()->json([
            'success' => true,
            'message' => 'Images uploaded successfully',
            'images' => $uploadedImages
        ]);    }

    /**
     * Display the specified resource.
     */
    public function show(ProductImage $productImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductImage $productImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductImage $productImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductImage $productImage)
    {
        // Delete the image file from storage
        if (file_exists(public_path($productImage->image_path))) {
            unlink(public_path($productImage->image_path));
        }
        
        $productImage->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully'
        ]);
    }
}
