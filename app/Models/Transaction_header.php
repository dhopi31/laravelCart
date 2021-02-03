<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction_header extends Model
{
    use HasFactory;
    protected $fillable = ['trans_code','user_id','total'];
}
