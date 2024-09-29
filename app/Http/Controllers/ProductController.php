<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(array $params)
{
    $products = Product::all(); // Получение всех товаров
    return Inertia::render('Welcome', array_merge($params, ['products' => $products]));
}

}
