<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction_detail;
use App\Models\User;


class Transaction_header extends Model
{
    use HasFactory;
    protected $fillable = ['trans_code','user_id','total'];

    public function transaction_detail()
    {
        return $this->hasMany(Transaction_detail::class, 'trans_code', 'trans_code');
    }

    public function user_name()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

}
