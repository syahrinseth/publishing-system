<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class AddPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:add {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Permission';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Permission::create(['name' => $this->argument('name')]);
        $this->info("Permission {$this->argument('name')} created!");
        return 0;
    }
}
