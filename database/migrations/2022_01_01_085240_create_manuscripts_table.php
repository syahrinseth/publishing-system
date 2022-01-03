<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManuscriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manuscripts', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->longText('title')->nullable();
            $table->longText('abstract')->nullable();
            $table->string('keywords')->nullable();
            $table->json('authors');
            $table->json('corresponding_authors');
            $table->string('category');
            $table->longText('funding_information')->nullable();
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
        Schema::dropIfExists('manuscripts');
    }
}
