<?php

it('filters using whereLocale() scope', function () {
    $a = get_post_class()::create(['title' => 'Hello']);
    $b = get_post_class()::create(['title' => 'World']);

    $a->setTranslation('de', 'title', 'Hallo')->save();
    $b->setTranslation('de', 'title', 'Welt')->save();

    $hits = get_post_class()::whereLocale('de', 'title', 'Hallo')->pluck('id')->all();
    expect($hits)->toContain($a->id)->not()->toContain($b->id);
});

it('sorts using orderByLocale() scope', function () {
    $a = get_post_class()::create(['title' => 'B-en']);
    $b = get_post_class()::create(['title' => 'C-en']);
    $c = get_post_class()::create(['title' => 'A-en']);

    $b->setTranslation('de', 'title', 'Apfel')->save();
    $c->setTranslation('de', 'title', 'Zebra')->save();

    $ordered = get_post_class()::orderByLocale('de', 'title', 'ASC')->pluck('title')->all();
    expect($ordered)->toBe(['C-en', 'B-en', 'A-en']);
})->throwsIf(fn () => env('DB_CONNECTION') === 'mongodb', \RuntimeException::class);

it('works using whereHasLocale() and whereMissingLocale() scopes', function () {
    $a = get_post_class()::create(['title' => 'Hello']);
    $b = get_post_class()::create(['title' => 'World']);

    $a->setTranslation('de', 'title', 'Hallo')->save();

    $hasDe = get_post_class()::whereHasLocale('de')->pluck('id')->all();
    $missingDe = get_post_class()::whereMissingLocale('de')->pluck('id')->all();

    expect($hasDe)->toContain($a->id)->not()->toContain($b->id);
    expect($missingDe)->toContain($b->id)->not()->toContain($a->id);
});
