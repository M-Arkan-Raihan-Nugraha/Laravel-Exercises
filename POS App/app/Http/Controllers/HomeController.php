<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'jumlah_pelanggan' => Customer::count(),
            'jumlah_kategori'    => Category::count(),
            'jumlah_produk'   => Product::count(),
        ];

        return view('home', $data);
    }

    public function testing(){
        $category = Category::get();
        $product = Product::with('category')->get();
        dd($product);
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}