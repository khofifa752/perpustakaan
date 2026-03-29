<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'cover',
        'author',
        'publisher',
        'description',
        'code',
        'stock',
        'category_id',
        'tahun_terbit'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }
}