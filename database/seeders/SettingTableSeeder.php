<?php

namespace Database\Seeders;

use App\Models\Manuscript;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Manuscript Settings
        # Manuscript Number Format.
        $manuscript_setting = Setting::where('type', Manuscript::class)
            ->where('name', 'manuscript_number_prefix')
            ->first();
        if (empty($manuscript_setting)) {
            $manuscript_setting = new Setting();
            $manuscript_setting->type = Manuscript::class;
            $manuscript_setting->name = "manuscript_number_prefix";
            $manuscript_setting->value = "";
            $manuscript_setting->notes = "";
            $manuscript_setting->meta = [];
            $manuscript_setting->save();
        }
    }
}
