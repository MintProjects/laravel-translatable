<?php

use Illuminate\Support\Facades\App;

it('stores and reads translation using setTranslation() with fallback', function () {
    $p = get_post_class()::create(['title' => 'Hello']);
    $p->setTranslation('de', 'title', 'Hallo')->save();

    expect($p->title)->toBe('Hello');
    expect($p->locale('de')->title)->toBe('Hallo');
    expect($p->locale('fr')->title)->toBe('Hello');
});

it('reads via in(locale) without mutating instance', function () {
    $p = get_post_class()::create(['title' => 'Hello']);
    $p->setTranslation('de', 'title', 'Hallo')->save();

    expect($p->title)->toBe('Hello');
    expect($p->in('de')->title)->toBe('Hallo');
    expect($p->title)->toBe('Hello');
});

it('stores via Mass Assignment using a locale map', function () {
    $p = get_post_class()::create([
        'title' => ['en' => 'Hello', 'de' => 'Hallo'],
    ]);

    expect($p->title)->toBe('Hello');
    expect($p->locale('de')->title)->toBe('Hallo');
});

it('sets translations using withLocale()', function () {
    $p = get_post_class()::create(['title' => 'Hello']);
    $p->withLocale('de', function ($m) {
        $m->title = 'Hallo';
        $m->save();
    });

    expect($p->title)->toBe('Hello');
    expect($p->locale('de')->title)->toBe('Hallo');
});

it('reads by current app locale', function () {
    $p = get_post_class()::create(['title' => 'Hello']);
    $p->setTranslation('de', 'title', 'Hallo')->save();

    App::setLocale('de');
    expect($p->title)->toBe('Hallo');

    App::setLocale('en');
    expect($p->title)->toBe('Hello');
});

it('works with getTranslation, getTranslations and localizations', function () {
    $p = get_post_class()::create(['title' => 'Hello']);
    $p->setTranslation('de', 'title', 'Hallo')->save();

    expect($p->getTranslation('de', 'title'))->toBe('Hallo');

    $all = $p->getTranslations();
    expect($all)->toHaveKey('de')
        ->and($all['de'])->toHaveKey('title', 'Hallo');

    $de = $p->getTranslations('de');
    expect($de)->toHaveKey('title', 'Hallo');

    $map = $p->localizations;
    expect($map)->toHaveKey('de');
});
