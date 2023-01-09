<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusInManuscriptMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manuscript_members', function (Blueprint $table) {
            $table->string('status')->after('role')->default('Active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manuscript_members', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
