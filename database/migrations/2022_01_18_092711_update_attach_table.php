<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAttachTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manuscript_attach_files', function(Blueprint $table) {
            $table->string('file_name')->nullable()->change();
            $table->string('file_location')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manuscript_attach_files', function(Blueprint $table) {
            $table->string('file_name')->change();
            $table->string('file_location')->change();
        });
    }
}
