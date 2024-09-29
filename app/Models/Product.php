<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',        // Название товара
        'price',       // Цена товара
    ];

    protected $casts = [
        'price' => 'decimal:2', // Преобразование цены в десятичное число с двумя знаками после запятой
    ];
}
