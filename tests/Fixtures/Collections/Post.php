<?php

namespace Rat\Translatable\Tests\Fixtures\Collections;

use MongoDB\Laravel\Eloquent\Model;
use Rat\Translatable\Concerns\Translatable;

class Post extends Model
{
    use Translatable;

    protected $collection = 'posts';
    protected $guarded = [];
    protected $translatable = ['title', 'meta'];
    protected $casts = [
        'meta'      => 'array',
        'options'   => 'array',
    ];
}
