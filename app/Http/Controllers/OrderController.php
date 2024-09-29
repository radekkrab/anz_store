<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $userId = Auth::id();

        $order = Order::create([
            'user_id' => $userId, // Получение ID текущего пользователя из авторизации Laravel
            'products' => $request->input('products'), // Получение списка товаров из запроса
            'total_price' => $request->input('totalPrice'), // Получение общей стоимости
        ]);
    }

    public function delete($id) {
        $order = Order::find($id);
        if ($order && $order->user_id == Auth::id()) {
            $order->delete();
        }
    }

    public function index()
    {
        $userId = Auth::id();
        $orders = Order::where('user_id', $userId)->get();
        return Inertia::render('Orders', ['orders' => $orders]);
    }
}
