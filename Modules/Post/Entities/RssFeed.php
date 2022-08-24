<?php

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Model;

class RssFeed extends Model
{
    protected $fillable = [];

    public function category(){
       return $this->belongsToMany('Modules\Post\Entities\Category');
    }
    public function subCategory(){
        return $this->belongsToMany('Modules\Post\Entities\SubCategory');
    }

    public function section(){
        return $this->belongsToMany('Modules\Post\Entities\Section');
    }

    public function state(){
        return $this->belongsToMany('Modules\Post\Entities\State');
    }
}
