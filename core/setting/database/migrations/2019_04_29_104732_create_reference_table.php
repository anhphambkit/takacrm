<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

class CreateReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('references', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code', 10)->nullable();
            $table->string('value');
            $table->string('slug');
            $table->string('type');
            $table->integer('order')->default(0);
            $table->boolean('is_default')->default(false);
            $table->boolean('publish')->default(true);
            $table->integer('group')->nullable();
            $table->timestamps();
        });

        if(Schema::hasTable('references')) {
            // Insert Reference:
            Artisan::call('db:seed', [
                '--class' => DataSettingReferenceSeeder::class,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('references');
    }
}
