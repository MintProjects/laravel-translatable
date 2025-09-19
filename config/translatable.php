<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Array-like casts
     |--------------------------------------------------------------------------
     |
     | List of cast types and cast classes that should be treated array-like.
     | Used to determine whether a translatable attribute should be stores
     | as array or interpreted as locale-to-value array map.
     |
     */
    'array_like_casts' => [
        'array',
        'json',
        'object',
        'collection',
        'encrypted:array',
        'encrypted:object',
        \Illuminate\Database\Eloquent\Casts\AsArrayObject::class,
        \Illuminate\Database\Eloquent\Casts\AsCollection::class,
    ],

    /*
     |--------------------------------------------------------------------------
     | Array-like attributes
     |--------------------------------------------------------------------------
     |
     | List of global attribute names that should always be treated array-like
     | even if they are not explicitly cast in the model. Used to handle
     | custom attributes or exceptions where array storage is required.
     |
     */
    'array_like_attributes' => [ ],

    /*
     |--------------------------------------------------------------------------
     | Translation model
     |--------------------------------------------------------------------------
     |
     | The Eloquent model that represents the translations. This class will be
     | used by the Translatable trait to store and retrieve localized values.
     |
     */
    'translatable_model' => \Rat\Translatable\Models\Translation::class,
];
