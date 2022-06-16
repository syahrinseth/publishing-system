<?php

use App\Models\Manuscript;
use App\Models\ManuscriptMember;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManuscriptMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table.
        Schema::create('manuscript_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manuscript_id');
            $table->foreign('manuscript_id')->references('id')->on('manuscripts')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('role');
            $table->timestamps();
        });

        // Migrate existing data to new table.
        $manuscripts = Manuscript::all();
        foreach($manuscripts as $key => $manuscript) {
            // Populate authors.
            $authors = $manuscript->authors ?? [];
            foreach ($authors as $author) {
                $member = new ManuscriptMember();
                $member->manuscript_id = $manuscript->id;
                $member->user_id = $author;
                $member->role = 'author';
                $member->save();
            }
            $corresponding_authors = $manuscript->corresponding_authors ?? [];
            foreach ($corresponding_authors as $author) {
                $member = new ManuscriptMember();
                $member->manuscript_id = $manuscript->id;
                $member->user_id = $author;
                $member->role = 'corresponding author';
                $member->save();
            }

            // Populate editors.
            $editors = $manuscript->editors ?? [];
            foreach ($editors as $author) {
                $member = new ManuscriptMember();
                $member->manuscript_id = $manuscript->id;
                $member->user_id = $author;
                $member->role = 'editor';
                $member->save();
            }

            // Populate reviewers.
            $reviewers = $manuscript->reviewers ?? [];
            foreach ($reviewers as $author) {
                $member = new ManuscriptMember();
                $member->manuscript_id = $manuscript->id;
                $member->user_id = $author;
                $member->role = 'reviewer';
                $member->save();
            }

            // Populate publishers.
            $publishers = $manuscript->publishers ?? [];
            foreach ($publishers as $author) {
                $member = new ManuscriptMember();
                $member->manuscript_id = $manuscript->id;
                $member->user_id = $author;
                $member->role = 'publisher';
                $member->save();
            }
        }

        // Remove manuscript member related columns
        Schema::table('manuscripts', function(Blueprint $table) {
            $table->dropColumn('authors');
            $table->dropColumn('corresponding_authors');
            $table->dropColumn('editors');
            $table->dropColumn('reviewers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $members = ManuscriptMember::all();
        foreach($members as $member) {
            $manuscript = Manuscript::find($member->manuscript_id);
            if (!empty($manuscript)) {
                if ($member->role == 'author') {
                    
                }
            }
        }
        Schema::dropIfExists('manuscript_members');
    }
}
