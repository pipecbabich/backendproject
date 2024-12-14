<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Product extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'name',
        'category_id',
        'name',
        'status',
        'price',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function attribute()
    {
        return $this->hasMany(Attribute::class,'product_id','id');
    }
}
