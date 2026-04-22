<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('user', 'category')->where('status', 'active')->latest()->take(6)->get();

        return view('home', compact('products'));
    }
}
