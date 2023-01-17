<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesOnJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journals', function(Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('journal_manuscripts', function(Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journals', function(Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('journal_manuscripts', function(Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
