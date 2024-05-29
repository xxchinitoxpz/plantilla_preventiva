<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employees extends Model
{
    use HasFactory;
    protected $fillable = ['full_name','document_number','phone','email','birthdate','sex','nationality','address','role','state','document_type_id'];

    //relacion uno a muchos con document_type (inversa)
    public function documents_type(){
        return $this->belongsTo('App\Models\documents_type');
    }

    //relacion de uno a muchos con payments
    public function payments(){
        return $this->hasMany('App\Models\payments');
    }
}
