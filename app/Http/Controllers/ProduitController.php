<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProduitController extends Controller
{

    // GET /api/produits - Récupère la liste de tous les produits
    public function index()
    {
        $product = Produit::all();
        return response($product);
    }

    // POST /api/produits - Crée un nouveau produit
    public function store(Request $request)
    {
        try {

            // Validation des champs, y compris le fichier image
            $request->validate([
                'nom' => 'required|string|max:255',
                'description' => 'required|string',
                'prix' => 'required|numeric',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Validation du fichier image
            ]);
            $produit = new Produit();
            $produit->nom = $request->nom;
            $produit->description = $request->description;
            $produit->prix = $request->prix;
            $newname = uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $save = $request->file("image")->storeAs("produits", $newname);
            if ($save) {
                $produit->image_path = $newname;
                $produit->save();
            }
            return response()->json(['produit' => $produit, "message" => "produit est ajouter"]);
        } catch (ValidationException $error) {
            return response($error->errors(), 500);
        }
    }

    // GET /api/produits/{id} - Récupère un produit par son ID
    public function show($id)
    {
        $produit = Produit::findOrFail($id);
        return response()->json($produit);
    }

    // PUT/PATCH /api/produits/{id} - Met à jour un produit existant
    public function update(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);

        // Validation des champs, y compris le fichier image
         $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Validation du fichier image
        ]);
        
            $produit->nom = $request->nom;
            $produit->description = $request->description;
            $produit->prix = $request->prix;
            
            $produit->save();

        // Gestion de l'image
        if ($request->hasFile('image')) {
            // Supprime l'ancienne image si elle existe
            // if ($produit->image_path) {
            //     Storage::disk('public')->delete($produit->image_path);
            // }

            // Stocke la nouvelle image
            $newname = uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $save = $request->file("image")->storeAs("produits", $newname);
            if ($save) {
                $produit->image_path = $newname;
                $produit->save();
            }
        }

       

        return response()->json($produit, 200);
    }

    // DELETE /api/produits/{id} - Supprime un produit
    public function destroy($id)
    {
        $produit = Produit::findOrFail($id);

        // Supprime l'image associée si elle existe
        // if ($produit->image_path) {
        //     Storage::disk('produits')->delete($produit->image_path);
        // }

        $produit->delete();
        
        

        return response(["produits"=>Produit::all()]);
    }
}
