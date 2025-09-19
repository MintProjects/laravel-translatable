<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint as MongoDBBlueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();
        if ($driver === 'mongodb') {
            Schema::create('posts', function (MongoDBBlueprint $collection) {
                $collection->index('title');
            });
        } else {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('content')->nullable();
                $table->json('meta')->nullable();
                $table->json('options')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::connection()->getDriverName();
        if ($driver === 'mongodb') {
            Schema::drop('posts');
        } else {
            Schema::dropIfExists('posts');
        }
    }
};
