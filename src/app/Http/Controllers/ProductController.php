<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
  {
    $products = Product::paginate(6);
    return view('index', compact('products'));
  }

   public function create()
    {
        return view('register'); 
    }
}
