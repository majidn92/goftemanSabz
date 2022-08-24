<?php

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [];

    public function category()
    {
        return $this->belongsTo('Modules\Post\Entities\Category');
    }

    public function post()
    {
        return $this->belongsToMany('Modules\Post\Entities\Post');
    }

    public function rssFeed()
    {
        return $this->belongsToMany('Modules\Post\Entities\RssFeed');
    }
}
