<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('custom-fields.tables.name', 'custom_fields'), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('value');
            $table->string('type')->nullable();
            $table->morphs('model');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('custom-fields.tables.name', 'custom_fields'));
    }
};