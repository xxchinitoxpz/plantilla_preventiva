<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class discounts extends Model
{
    use HasFactory;
    protected $fillable = ['amount','discount_type','payment_id','user_id'];

    //relacion uno a muchos con users (inversa)
    public function users(){
        return $this->belongsTo('App\Models\user');
    }
}
