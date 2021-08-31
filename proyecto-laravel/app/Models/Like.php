<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = "likes";

    //Muchos a uno
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //Muchos a uno
    public function images()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
