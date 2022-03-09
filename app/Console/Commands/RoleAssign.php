<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAssign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:assign {name} {permission}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign a permission into a role.';

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
        $role = Role::where('name', $this->argument('name'))->first();
        $permissions = Permission::where('name', 'like', "%" . $this->argument('permission') . "%")->get();
        if (!empty($role) && count($permissions) > 0) {
            $role->givePermissionTo($permissions);
            $this->info("Permission {$this->argument('permission')} assigned to role {$this->argument('name')}!");
            return 0;
        }
        $this->error("Role or Permission not found.");
        return 0;
    }
}
