<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveForeignManuscriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manuscript_members', function(Blueprint $table) {
            $table->dropForeign('manuscript_members_manuscript_id_foreign');
            $table->dropForeign('manuscript_members_user_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manuscript_members', function(Blueprint $table) {
            $table->foreign('manuscript_id')->references('id')->on('manuscripts')->onDelete('cascade')->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->change();
        });
    }
}
