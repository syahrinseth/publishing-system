<?php

use App\Models\Manuscript;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddManuscriptNumberOnManuscriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manuscripts', function(Blueprint $table) {
            $table->string('manuscript_no')->nullable();
        });

        // Generate manuscript number
        $manuscripts = Manuscript::all();
        $manuscript_setting = Setting::where('type', Manuscript::class)
            ->where('name', 'manuscript_number_prefix')
            ->firstOrFail();
        foreach ($manuscripts as $manuscript) {
            $manuscript->manuscript_no = $manuscript_setting->generateManuscriptNo($manuscript);
            $manuscript->update();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
