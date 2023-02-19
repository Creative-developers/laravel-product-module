<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    
    protected $fillable = ['name','price','status','user_id', 'type'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
