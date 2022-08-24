<?php

namespace Modules\Gallery\Entities;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = [];

    public function galleryImages()
    {
        return $this->hasMany('Modules\Gallery\Entities\GalleryImage');
    }

    public function section()
    {
        return $this->belongsTo('Modules\Post\Entities\Section');
    }
}
