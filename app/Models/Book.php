<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
    'title',
    'author',
    'publisher',
    'publication_year',
    'stock',
    'image', // Biarkan image di sini
];
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }
}
