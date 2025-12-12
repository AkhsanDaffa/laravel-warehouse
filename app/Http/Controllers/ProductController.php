<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 1. Tampilkan Dashboard Gudang
    public function index()
    {
        // Ambil barang terbaru dulu
        $products = Product::latest()->get(); 
        return view('warehouse', compact('products'));
    }

    // 2. Tambah Barang Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'stock' => 'required|integer|min:0'
        ]);

        Product::create($request->all());

        return redirect('/')->with('success', 'Barang berhasil didaftarkan!');
    }

    // 3. Update Stok (Masuk/Keluar)
    public function updateStock(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        if ($request->action == 'in') {
            $product->increment('stock'); // Tambah 1
            $msg = 'Stok bertambah!';
        } else {
            if ($product->stock > 0) {
                $product->decrement('stock'); // Kurang 1
                $msg = 'Stok berkurang!';
            } else {
                return redirect('/')->with('error', 'Stok sudah habis!');
            }
        }

        return redirect('/')->with('success', $msg . ' (' . $product->name . ')');
    }

    // 4. Hapus Barang
    public function destroy($id)
    {
        Product::destroy($id);
        return redirect('/')->with('success', 'Barang dihapus dari sistem.');
    }
}