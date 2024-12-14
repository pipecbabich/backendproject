<?php

namespace App\Models;

use App\Enums\AttributeName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Attribute extends Model
{
    use AsSource, Filterable, Attachable;
    
    protected $fillable = [
        'name',
        'value',
        'product_id'
    ];

    protected $hidden = ['id', 'product_id', 'created_at', 'updated_at'];

    protected function casts(): array
    {
        return [
            'name' => AttributeName::class
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
