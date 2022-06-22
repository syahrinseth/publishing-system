<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReviewedVodeColumnOnTableManuscriptMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manuscript_members', function(Blueprint $table) {
            $table->string('reviewedVote')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manuscript_members', function(Blueprint $table){
            $table->dropColumn('reviewedVote');
        });
    }
}
