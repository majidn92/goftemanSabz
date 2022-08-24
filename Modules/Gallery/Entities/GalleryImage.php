<?php

namespace Modules\Gallery\Entities;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{

    protected $guarded = [];

    public function gallery_images()
    {
        return $this->hasMany(self::class);
    }

}
