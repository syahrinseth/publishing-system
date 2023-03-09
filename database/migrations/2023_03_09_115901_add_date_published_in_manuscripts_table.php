<?php

use App\Models\Manuscript;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDatePublishedInManuscriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manuscripts', function (Blueprint $table) {
            $table->timestamp('date_published')->nullable()->after('status');
        });

        $manuscripts = Manuscript::where('status', 'Published')->update([
            'date_published' => \Carbon\Carbon::now()
        ]);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manuscripts', function (Blueprint $table) {
            $table->dropColumn('date_published');
        });
    }
}
