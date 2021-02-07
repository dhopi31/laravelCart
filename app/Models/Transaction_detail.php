<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction_header;
use App\Models\Product;

class Transaction_detail extends Model
{
    use HasFactory;
    protected $fillable = ['trans_code','item_id','quantity'];

    public function transaction_header()
    {
        return $this->belongsTo(Transaction_header::class);
    }

    public function item_name()
    {   
        return $this->hasOne(Product::class, 'id', 'item_id');
    }
}
