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
            Schema::create('translations', function (MongoDBBlueprint $collection) {
                $collection->unique(['model_type', 'model_id', 'locale'], 'uniq_model_locale');
            });
        } else {
            Schema::create('translations', function (Blueprint $table) {
                $table->id();
                $table->string('locale');
                $table->morphs('model');
                $table->json('strings')->nullable();
                $table->timestamps();

                $table->unique(['model_type', 'model_id', 'locale']);
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
            Schema::drop('translations');
        } else {
            Schema::dropIfExists('translations');
        }
    }
};
