<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImages;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'brand', 'code', 'image', 'price', 'description', 'stock_quantity','status','category_id'
    ];

    public function images(){
        return $this->hasMany(ProductImages::class);
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
}
