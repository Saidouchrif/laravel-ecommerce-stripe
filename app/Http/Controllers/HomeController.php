<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Afficher tous les produits avec filtres
     */
    public function showAllProducts(Request $request)
    {
        $query = Produit::where('is_active', true)->with(['images', 'categorie']);

        // Filtre par Recherche (Nom)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name_produit', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtre par Catégorie
        if ($request->filled('categories')) {
            $categories = $request->input('categories');
            if (is_array($categories)) {
                $query->whereIn('id_categorie', $categories);
            }
        }

        // Filtre par Prix
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        $produits = $query->paginate(12)->withQueryString();
        $categories = \App\Models\Categorie::where('is_active', true)->withCount('produits')->get();
        $maxPrice = Produit::max('price') ?? 1000;

        // Traductions des couleurs pour l'affichage éventuel
        $colorTranslations = $this->getColorTranslations();

        return view('home.Produits.index', compact('produits', 'categories', 'maxPrice', 'colorTranslations'));
    }

    /**
     * Afficher la page d'accueil du produit
     */
    public function showProductLanding()
    {
        // Rechercher le produit spécifique
        $produit = Produit::where('name_produit', 'Manette PS5 – Master Copier')
            ->with(['images']) // Charger les images liées
            ->firstOrFail();

        // Préparer les traductions de couleurs
        $colorTranslations = $this->getColorTranslations();

        return view('home.index', compact('produit', 'colorTranslations'));
    }

    /**
     * Obtenir les traductions de couleurs selon la locale active
     *
     * @return array
     */
    private function getColorTranslations(): array
    {
        return [
            'noir' => __('store.colors.black'),
            'blanc' => __('store.colors.white'),
            'rouge' => __('store.colors.red'),
            'bleu' => __('store.colors.blue'),
            'vert' => __('store.colors.green'),
            'jaune' => __('store.colors.yellow'),
            'violet' => __('store.colors.purple'),
            'orange' => __('store.colors.orange'),
            'gris' => __('store.colors.gray'),
            'rose' => __('store.colors.pink'),
            'cyan' => __('store.colors.cyan'),
            'indigo' => __('store.colors.indigo'),
            'black' => __('store.colors.black'),
            'white' => __('store.colors.white'),
            'red' => __('store.colors.red'),
            'blue' => __('store.colors.blue'),
            'green' => __('store.colors.green'),
            'yellow' => __('store.colors.yellow'),
            'purple' => __('store.colors.purple'),
            'gray' => __('store.colors.gray'),
            'grey' => __('store.colors.gray'),
            'pink' => __('store.colors.pink'),
        ];
    }
    /**
     * Afficher les détails d'un produit
     */
    public function showProduct($id)
    {
        $produit = Produit::with(['images', 'categorie'])->findOrFail($id);
        $colorTranslations = $this->getColorTranslations();

        return view('home.Produits.show', compact('produit', 'colorTranslations'));
    }

    /**
     * Afficher la page de commande d'un produit
     */
    public function showCommande($id)
    {
        $produit = Produit::with(['images', 'categorie'])->findOrFail($id);
        return view('home.Produits.commande', compact('produit'));
    }

}