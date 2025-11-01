<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::all();
        return view('product.index', compact('data'));
    }

    public function create()
    {
        $category = Category::all();
        return view('product.form', compact('category'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            Product::create($request->all());
            DB::commit();
            return redirect('product')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('product')->with('error', $e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        $category = Category::all();
        return view('product.form_edit', compact('product', 'category'));
    }

    public function update(Request $request, Product $product)
    {
        DB::beginTransaction();
        try {
            $product->update($request->all());
            DB::commit();
            return redirect('product')->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('product')->with('error', $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect('product')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect('product')->with('error', $e->getMessage());
        }
    }
}
