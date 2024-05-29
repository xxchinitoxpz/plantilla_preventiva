<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bonuses extends Model
{
    use HasFactory;

    protected $fillable = ['amount','description','payment_id','user_id'];

    //relacion uno a muchos con users (inversa)
    public function users(){
        return $this->belongsTo('App\Models\user');
    }

    //relacion uno a muchos con payments (inversa)
    public function payments(){
        return $this->belongsTo('App\Models\payments');
    }
}
