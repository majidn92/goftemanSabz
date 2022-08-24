<?php

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [];
    public $timestamps = false;

    public function posts()
    {
        return $this->belongsToMany('Modules\Post\Entities\Post');
    }

    public function center_ads()
    {
        return $this->hasMany('Modules\Ads\Entities\CenterAd');
    }

    public function rss_feed(){
        return $this->belongsToMany('Modules\Post\Entities\RssFeed');
    }
}
