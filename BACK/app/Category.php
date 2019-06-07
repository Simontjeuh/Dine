<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        // 'description',
        // 'photo'
    ];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
