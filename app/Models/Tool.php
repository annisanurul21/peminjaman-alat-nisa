<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'tools';

    // Kolom yang boleh diisi
    protected $fillable = [
    'category_id', 
    'code', 
    'name', 
    'description', 
    'stock', 
    'image'
];

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}