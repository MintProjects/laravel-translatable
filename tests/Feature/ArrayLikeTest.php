<?php

it('stores array attributes using an appropriate cast', function () {
    $post = get_post_class()::create([
        'title' => 'Hello',
        'meta'  => ['tags' => ['one', 'two']],
    ]);
    expect($post->meta)->toBe(['tags' => ['one', 'two']]);

    $post->setTranslation('de', 'meta', ['tags' => ['eins', 'zwei']])->save();
    expect($post->meta)->toBe(['tags' => ['one', 'two']]);
    expect($post->locale('de')->meta)->toBe(['tags' => ['eins', 'zwei']]);
});

it('stores array attributes using array_like_attributes', function () {
    $post = get_post_class()::create([
        'title'     => 'Hello',
        'options'   => ['ui' => ['dark' => true]]
    ]);
    expect($post->options)->toBe(['ui' => ['dark' => true]]);
    expect($post->locale('de')->options)->toBe(['ui' => ['dark' => true]]);
});

it('still stores non-translatable arrays', function () {
    $post = new (get_post_class())();
    $post->setRawAttributes([]);
    $post->unguard();

    $reflect = new \ReflectionClass($post);
    $prop = $reflect->getProperty('translatable');
    $prop->setAccessible(true);
    $prop->setValue($post, ['title']);

    $post->title = 'Hello';
    $post->meta = ['a' => 1];
    $post->save();

    expect($post->locale('de')->meta)->toBe(['a' => 1]);
});

it('throws when storing array on translatable+non-array-like-cast attribute', function () {
    $post = new (get_post_class())();
    $post->setRawAttributes([]);
    $post->unguard();

    $reflect = new \ReflectionClass($post);
    $prop = $reflect->getProperty('casts');
    $prop->setAccessible(true);
    $prop->setValue($post, ['options' => 'array']);

    $post->title = 'Hello';
    $post->meta = ['a' => 1];
    $post->save();

    expect($post->locale('de')->meta)->toBe(['a' => 1]);
})->throws(\InvalidArgumentException::class);
