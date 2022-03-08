<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AddRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:add {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a role.';

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
        Role::create(['name' => $this->argument('role')]);
        $this->info("Role {$this->argument('role')} created!");
        return 0;
    }
}
