<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    /**
     * Admin paneli için ürün listesini göster.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Yeni ürün oluşturma formunu göster.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Yeni ürünü kaydet.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'calories' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);


        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }
        Product::create([
            'title' => $request->title,
            'image' => $imagePath,
            'calories' => $request->calories,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Ürün başarıyla eklendi!');
    }

    /**
     * Ürün düzenleme formunu göster.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Ürünü güncelle.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'calories' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'title' => $request->title,
            'image' => $imagePath,
            'calories' => $request->calories,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Ürün başarıyla güncellendi!');
    }

    /**
     * Ürünü sil.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        // Fotoğrafın varlığını kontrol et ve storage'dan sil
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Ürün kaydını veritabanından sil
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Ürün başarıyla silindi!');
    }

    /**
     * Seçilen ürünleri toplu olarak sil.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulkDelete(Request $request)
    {
        $productIds = $request->input('product_ids');

        // Eğer ID'ler varsa işlemi yap
        if (!empty($productIds)) {
            $products = Product::whereIn('id', $productIds)->get();

            foreach ($products as $product) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
            }

            Product::whereIn('id', $productIds)->delete();

            return redirect()->route('admin.products.index')->with('success', 'Seçilen ürünler başarıyla silindi.');
        }

        return redirect()->route('admin.products.index')->with('error', 'Silinecek ürün seçilmedi.');
    }
}
