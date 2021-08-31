<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $table = "follows";

    //Muchos a uno
    public function users(){
        return $this->belongsTo(User::class, 'id');
    }
}
