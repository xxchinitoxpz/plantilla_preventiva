<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payments extends Model
{
    use HasFactory;

    protected $fillable = ['amount','final_amount','payment_type','employee_id','payment_method_id','user_id'];

    //relacion uno a muchos con employees (inversa)
    public function employees(){
        return $this->belongsTo('App\Models\employees');
    }

    //relacion uno a muchos con employees (inversa)
    public function payment_methods(){
        return $this->belongsTo('App\Models\payment_methods');
    }

    //relacion uno a muchos con users (inversa)
    public function users(){
        return $this->belongsTo('App\Models\user');
    }

    //relacion de uno a muchos con bonuses
    public function bonuses(){
        return $this->hasMany('App\Models\bonuses');
    }

    //relacion de uno a muchos con discounts
    public function discounts(){
        return $this->hasMany('App\Models\discounts');
    }
}
