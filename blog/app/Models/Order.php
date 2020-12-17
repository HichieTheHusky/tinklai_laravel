<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->belongsToMany(product::class, 'items', 'fk_order', 'fk_product')->withPivot('status','quantity');
    }

    public function getAvailableAttribute()
    {
        return $this->items()->where('status', '1')->count() === $this->items()->count();
    }
}
