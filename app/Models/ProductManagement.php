<?php

namespace App\Models;

use App\Models\StockManagement\Stock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductManagement extends Model
{
    use HasFactory;

    public function stock()
    {
        return $this->belongsToMany(Stock::class, 'product_stocks')->withPivot('id', 'quantity');

    }
}
