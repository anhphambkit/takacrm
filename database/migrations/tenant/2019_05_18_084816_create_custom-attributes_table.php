<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Attribute Table
        Schema::create('custom_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120)->unique();
            $table->string('slug', 150)->unique();
            $table->string('description')->nullable();
            $table->string('type_entity')->comment('product|customer|order');
            $table->string('type_value')->nullable();
            $table->string('type_render')->nullable();
            $table->boolean('is_required')->default(false);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->boolean('status')->unsigned()->default(1);
            $table->timestamps();
        });

        if(Schema::hasTable('references')) {
            // Insert Reference:
            Artisan::call('db:seed', [
                '--class' => DataCustomAttributesReferenceSeeder::class,
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
        Schema::dropIfExists('custom_attributes');
    }
}
