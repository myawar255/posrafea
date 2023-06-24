<?php

namespace App\Models\CatalogueManagement;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatStockUnit extends Model
{
    use HasFactory;

    protected $table = 'cat_stock_unit';

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

    public $relationMethods = [];
}
