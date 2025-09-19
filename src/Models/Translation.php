<?php declare(strict_types=1);

namespace Mint\Translatable\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    /**
     * The table associated with the model.
     * @var string|null
     */
    protected $table = 'translations';

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
     * @var array
     */
    protected $casts = [
        'strings'       => 'array',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];
}
