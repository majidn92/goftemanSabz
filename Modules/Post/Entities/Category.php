<?php

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Model;
use LaravelLocalization;
use Sentinel;

class Category extends Model
{
    protected $fillable = ['category_name', 'language', 'slug', 'meta_description', 'meta_keywords', 'order', 'show_on_menu', 'show_on_homepage'];

    public function subCategory()
    {
        return $this->hasMany('Modules\Post\Entities\SubCategory');
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

