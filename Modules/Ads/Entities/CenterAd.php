<?php

namespace Modules\Ads\Entities;

use Illuminate\Database\Eloquent\Model;

class CenterAd extends Model
{
    // protected $fillable = [];
    protected $guarded = array();

    public function adImage(){
        return $this->belongsTo('Modules\Gallery\Entities\Image', 'ad_image_id','id');
    }

    public function section(){
        return $this->belongsTo('Modules\Post\Entities\Section');
    }
}
