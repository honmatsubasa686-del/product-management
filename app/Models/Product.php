<?php

namespace App\Models;

use App\Models\Season;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'image',
        'description',
    ];

    public function seasons()
    {
        return $this->belongsToMany(Season::class);
    }
}
