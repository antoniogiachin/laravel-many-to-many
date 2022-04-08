<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //dico che category ha molti post
    // funzione dal nome post()
    public function post(){
        return $this->hasMany('App\Post');
    }
}
