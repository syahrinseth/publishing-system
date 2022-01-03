<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManuscriptAttachFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manuscript_attach_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manuscript_id');
            $table->foreign('manuscript_id')->references('id')->on('manuscripts');
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->string('file_name');
            $table->string('file_location');
            $table->double('size');
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
        Schema::dropIfExists('manuscript_attach_files');
    }
}
