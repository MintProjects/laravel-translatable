<?php

use Mint\Translatable\Tests\TestCase;

if (!function_exists('get_post_class')) {
    function get_post_class() {
        return config('translatable.test_model');
    }
}

uses(TestCase::class)->in(__DIR__);
