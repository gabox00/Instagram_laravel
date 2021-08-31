<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = "images";

    //uno a muchos
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    //uno a muchos
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    //Muchos a uno
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
