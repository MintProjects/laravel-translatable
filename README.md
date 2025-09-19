rat.md/laravel-translatable
===========================

Most Laravel “translatable” packages force you to either convert your translatable attributes into a 
JSON column on the same table (for storing all strings on one place), or requires you to create and 
maintain a dedicated `{model}_translations` table for each model.

Both approaches work, but they either bloat your base table with JSON logic or force you to manage a 
growing number of nearly identical tables.

`rat.md/laravel-translatable` takes a different path — inspired by OctoberCMS — by using a 
**single, shared translations table** for all your models.

## Features

- **Support for** MySQL, MariaDB, PostgreSQL, SQlite and MongoDB (Driver-aware querying and sorting).
- **One polymorphic translations table** for everything — no extra migrations per model.  
- **Keep your default language clean** in the model’s own columns, exactly where it belongs.  
- **Transparent reads and writes** through the model’s attributes, with automatic fallback.  

## Requirements

- PHP ≥ 8.2
- Laravel ≥ 11
- SQLite ≥ 3.35 | MySQL ≥ 8.0 | MariaDB ≥ 10.6 | PostgreSQL ≥ 13.22
- Only required for MongoDB driver (experimental):
    - MongoDB ≥ v7.0 (may work with ≥ v5.0 too)
    - [mongodb/laravel-mongodb ≥ 5.0](https://github.com/mongodb/laravel-mongodb)


## Installation

Install the package via composer:

```bash
composer require rat.md/laravel-translatable
```

Publish and run the migrations using:

```bash
php artisan vendor:publish --tag="laravel-translatable-migrations"
php artisan migrate
```

Publish the configuration file with:

```bash
php artisan vendor:publish --tag="laravel-translatable-config"
```

## Usage

### Preparing your models

Simply add the `Translatable` trait to your Eloquent models and declare which attributes should 
support translations. Array-Like attributes must be declared either in your `$casts` or in the 
package-native `$translatableArrayAttributes` model property.

```php
use Rat\Translatable\Concerns\Translatable;

class Post extends Model
{
    use Translatable;

    protected $fillable = ['title', 'content', 'tags'];
    protected $translatable = ['title', 'content', 'tags'];
    protected $casts = [
        'tags' => 'array'
    ];
}
```

### Setting translations

Set translations in known / familiar ways.

```php
// Mass assignment
Post::create([
    'title' => [
        'en' => 'Hello World',
        'de' => 'Hallo Welt',
    ]
]);

// Manual assignment
$post = new Post;
$post->title = 'Hello World';
$post->setTranslation('de', 'title', 'Hallo Welt');
$post->save();

// Manual assignment using withLocale()
$post = new Post;
$post->title = 'Hello World';
$post->withLocale('de', function ($model) {
    $model->title = 'Hallo Welt';
});
```

### Retrieving translations

Access translations directly, use helpers, or switch the application/model locale.

```php
$post = Post::first();

// Direct access based on app()->getLocale()
echo $post->title;
app()->setLocale('de');
echo $post->title;

// Manual access
echo $post->getTranslation('de', 'title');
echo $post->getTranslations('de')['title'];

// Access by mutating model locale
$post->locale('de');
echo $post->title;

// Access by cloning model with desired locale
echo $post->in('de')->title;

// Access by using withLocale()
$post->withLocale('de', function ($model) {
    echo $model->title;
});
```

### Querying by locale

Query, filter, and sort your models by translated values across different locales.

> [!NOTE]
> `orderByLocale()` is not yet supported for the MongoDB driver. We are actively exploring a clean 
> and efficient implementation. For now, this scope works only with SQL drivers.

```php
Post::whereLocale('de', 'title', 'Hallo Welt')->get();
Post::query()->whereLocale('de', 'title', 'Hallo Welt')->get();

Post::whereHasLocale('de')->get();
Post::whereMissingLocale('de')->get(); // or "whereDoesntHaveLocale"

Post::orderByLocale('de', 'title', 'ASC')->get();
```

## Testing

```bash
./vendor/bin/pest
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.


## License
Published under MIT License \
Copyright © 2024 - 2025 Sam @ rat.md
