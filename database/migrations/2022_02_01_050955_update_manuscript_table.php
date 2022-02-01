<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateManuscriptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manuscripts', function(Blueprint $table) {
            $table->json('additional_informations')->nullable();
            $table->text('short_title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manuscripts', function(Blueprint $table) {
            $table->dropColumn('additional_informations');
            $table->dropColumn('short_title');
        });
    }
}
