<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ready extends Model
{
    use HasFactory;
    
    protected $fillable = ['day_id', 'category_id', 'lote', 'quantity', 'price', 'description', 'status', 'deleted_at'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
