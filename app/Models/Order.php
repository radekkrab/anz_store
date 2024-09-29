<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // ID пользователя, сделавшего заказ
        'products', // Список товаров в формате JSON
        'total_price', // Общая стоимость заказа
    ];

    protected $casts = [
        'products' => 'array', // Преобразование JSON в массив
    ];

    public function getTotalPriceAttribute()
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product['price'] * $product['quantity'];
        }
        return $total;
    }
}
