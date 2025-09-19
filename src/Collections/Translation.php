<?php declare(strict_types=1);

namespace Rat\Translatable\Collections;

use MongoDB\Laravel\Eloquent\Model;

class Translation extends Model
{
    /**
     * The table associated with the model.
     * @var string|null
     */
    protected $collection = 'translations';

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
    protected $fillable = [
        'locale',
        'model_id',
        'model_type',
        'strings',
    ];

    /**
     * The attributes that should be cast.
     * @note using 'strings' => 'array' (or 'object') destroys the "MongoDB\Model\BSONDocument"
     *       casting, for whatever reason.
     * @var array
     */
    protected $casts = [
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];
}
