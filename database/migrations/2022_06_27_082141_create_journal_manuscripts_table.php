<?php

use App\Models\JournalManuscript;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalManuscriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_manuscripts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journal_id');
            $table->foreign('journal_id')->references('id')->on('journals')->onDelete('cascade');
            $table->unsignedBigInteger('manuscript_id');
            $table->foreign('manuscript_id')->references('id')->on('manuscripts')->onDelete('cascade');
            $table->timestamps();
        });

        // Journal.
        $journals = DB::table('journals')->get();
        // Migrate Manusdripts into journal_manuscripts.
        foreach ($journals as $journal) {
            $manuscripts = json_decode($journal->manuscripts ?? "[]");
            foreach($manuscripts as $manuscript) {
                $journalManuscript = new JournalManuscript();
                $journalManuscript->journal_id = $journal->id;
                $journalManuscript->manuscript_id = $manuscript;
                $journalManuscript->save();
            }
        }

        Schema::table('journals', function(Blueprint $table) {
            $table->dropColumn('manuscripts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal_manuscripts');
    }
}
