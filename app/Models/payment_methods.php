<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment_methods extends Model
{
    use HasFactory;
    protected $fillable = ['payment_method'];

    //relacion de uno a muchos con payments
    public function payments(){
        return $this->hasMany('App\Models\payments');
    }
}
