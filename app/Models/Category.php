<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes; //Trait
    //
    protected $fillable = [
        'name',
    ];
    public function posts(){
        return $this->morphedByMany(Post::class,'categoryable');
    }
}
