<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction_detail;

class Product extends Model
{
    use HasFactory;
    
    public function item_name()
    {   
        return $this->belongsTo(Transaction_detail::class);
    }
}
