<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchCategory extends Model
{
    use HasFactory;

    function merchandises(){
        return $this->hasMany(Merchandise::class, 'category_id', 'id');
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
