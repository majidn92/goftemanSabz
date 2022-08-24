<?php

namespace Modules\Ads\Entities;

use Illuminate\Database\Eloquent\Model;

class SideAd extends Model
{
    public function section(){
        return $this->belongsTo('Modules\Post\Entities\Section');
    }
}
