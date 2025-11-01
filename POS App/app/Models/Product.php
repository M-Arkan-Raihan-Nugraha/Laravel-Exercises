<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{

    protected $table = "products";
    protected $fillable = [
        "name",
        "description",
        "stock",
        "price",
        "category_id"
    ];

    use HasFactory;

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
