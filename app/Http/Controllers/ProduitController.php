<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\ProductImage;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Produit::with(['categorie', 'images'])->paginate(10);
        return view('admin.Produits.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categorie::where('is_active', true)->get();
        return view('admin.Produits.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request data
        $validated = $request->validate([
            'name_produit' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'id_categorie' => 'nullable|exists:categories,id_categorie',
            'images.*' => 'required|image|mimes:jpg,png,jpeg,webp|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // Create the product
            $produit = Produit::create([
                'name_produit' => $validated['name_produit'],
                'description' => $validated['description'] ?? null,
                'color' => $validated['color'] ?? null,
                'price' => $validated['price'],
                'id_categorie' => $validated['id_categorie'] ?? null,
                'is_active' => true,
            ]);

            // Handle image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // Store image in public/images/produits
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images/produits'), $filename);
                    $path = 'images/produits/' . $filename;
                    
                    // Create product image record
                    ProductImage::create([
                        'id_produit' => $produit->id_produit,
                        'image_path' => $path,
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Product created successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Produit $produit)
    {
        $produit->load(['categorie', 'images']);
        return view('admin.Produits.show', compact('produit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produit $produit)
    {
        $categories = Categorie::where('is_active', true)->get();
        $produit->load(['categorie', 'images']);
        return view('admin.Produits.edit', compact('produit', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produit $produit)
    {
        // Validate request data
        $validated = $request->validate([
            'name_produit' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'id_categorie' => 'nullable|exists:categories,id_categorie',
            'is_active' => 'required|boolean',
            'images.*' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
            'deleted_images' => 'nullable|array',
            'deleted_images.*' => 'exists:product_images,id_image',
        ]);

        try {
            DB::beginTransaction();

            // Handle image deletions FIRST (before updating product)
            if (!empty($validated['deleted_images'])) {
                $imagesToDelete = ProductImage::whereIn('id_image', $validated['deleted_images'])
                    ->where('id_produit', $produit->id_produit)
                    ->get();
                
                foreach ($imagesToDelete as $image) {
                    // Delete the physical file if it exists
                    $fullPath = public_path($image->image_path);
                    if (File::exists($fullPath)) {
                        File::delete($fullPath);
                    }
                    // Delete the database record
                    $image->delete();
                }
            }

            // Update the product
            $produit->update([
                'name_produit' => $validated['name_produit'],
                'description' => $validated['description'] ?? null,
                'color' => $validated['color'] ?? null,
                'price' => $validated['price'],
                'id_categorie' => $validated['id_categorie'] ?? null,
                'is_active' => $validated['is_active'],
            ]);

            // Handle image uploads if provided
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // Store image in public/images/produits
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images/produits'), $filename);
                    $path = 'images/produits/' . $filename;
                    
                    // Create product image record
                    ProductImage::create([
                        'id_produit' => $produit->id_produit,
                        'image_path' => $path,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('produits.show', $produit->id_produit)->with('success', 'Product updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        try {
            DB::beginTransaction();

            // Delete associated images first
            foreach ($produit->images as $image) {
                // Delete the physical file if it exists
                $fullPath = public_path($image->image_path);
                if (File::exists($fullPath)) {
                    File::delete($fullPath);
                }
                $image->delete();
            }

            // Delete the product
            $produit->delete();

            DB::commit();

            return redirect()->route('produits.index')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }
}
