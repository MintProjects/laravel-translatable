<?php

namespace Mint\Translatable\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;
use Mint\Translatable\Concerns\Translatable;

class Post extends Model
{
    use Translatable;

    protected $table = 'posts';
    protected $guarded = [];
    protected $translatable = ['title', 'meta'];
    protected $casts = [
        'meta'      => 'array',
        'options'   => 'array',
    ];
}
