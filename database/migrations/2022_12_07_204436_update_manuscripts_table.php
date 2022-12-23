<?php

use App\Models\Manuscript;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateManuscriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manuscripts', function(Blueprint $table) {
            $table->boolean('is_confirm_grant_numbers')->default(false);
            $table->boolean('is_acknowledge')->default(false);
        });

        $manuscripts = Manuscript::all();
        foreach ($manuscripts as $manuscript) {
            $manuscript->is_confirm_grant_numbers = json_decode($manuscript->additional_informations)?->is_confirm_grant_numbers ?? false;
            $manuscript->is_acknowledge = json_decode($manuscript->additional_informations)?->is_acknowledge ?? false;
            $manuscript->update();
        }

        Schema::table('manuscripts', function(Blueprint $table) {
            $table->dropColumn('additional_informations');
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
            $table->json('additional_informations');
        });

        $manuscripts = Manuscript::all();
        foreach ($manuscripts as $manuscript) {
            $manuscript->additional_informations = json_encode([
                "is_confirm_grant_numbers" => $manuscript->is_confirm_grant_numbers,
                "is_acknowledge" => $manuscript->is_acknowledge
            ]);
            $manuscript->update();
        }

        Schema::table('manuscripts', function(Blueprint $table) {
            $table->dropColumn('is_confirm_grant_numbers');
            $table->dropColumn('is_acknowledge');
        });
    }
}
