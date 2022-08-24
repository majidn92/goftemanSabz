<?php

namespace Modules\Gallery\Entities;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    protected $fillable = ['post_id'];
    protected $table = 'audios';

    public function posts()
    {
        return $this->hasMany('Modules\Post\Entities\Post');
    }
}
