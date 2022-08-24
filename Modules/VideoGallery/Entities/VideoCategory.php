<?php

namespace Modules\VideoGallery\Entities;

use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model
{
    public $timestamps = false;

    public function videos()
    {
        return $this->hasMany('Modules\VideoGallery\Entities\VideoGallery');
    }
}
