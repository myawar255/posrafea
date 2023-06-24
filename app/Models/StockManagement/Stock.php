<?php

namespace App\Models\StockManagement;

use App\Models\CatalogueManagement\CatStockUnit;
use App\Models\ProductManagement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock';

    /**
     * Get the user that created the data.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * Get the user that updated the data.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * Get the unit that stock belongs to.
     */
    public function unit()
    {
        return $this->belongsTo(CatStockUnit::class,'unit_id','id');
    }

    public function product()
    {
        return $this->belongsToMany(ProductManagement::class, 'product_stocks')->withPivot('id', 'quantity');

    }

    public $relationMethods = [];
}
