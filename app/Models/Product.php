<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'link',
        'price',
    ];

    // Relasi ke Rental
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}