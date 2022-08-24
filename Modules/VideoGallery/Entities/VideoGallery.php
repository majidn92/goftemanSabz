<?php

namespace Modules\VideoGallery\Entities;

use Illuminate\Database\Eloquent\Model;

class VideoGallery extends Model
{
    public function video_category()
    {
        return $this->belongsTo('Modules\VideoGallery\Entities\VideoCategory');
    }

    public function section()
    {
        return $this->belongsTo('Modules\Post\Entities\Section');
    }
}
