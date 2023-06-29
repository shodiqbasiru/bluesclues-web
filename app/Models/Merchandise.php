<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchandise extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function merchCategory(){
        return $this->belongsTo(MerchCategory::class, 'category_id', 'id');
    }

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class, 'merchandise_id', 'id');
    }
}
