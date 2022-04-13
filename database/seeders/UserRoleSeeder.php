<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{

    protected $roles = [
        'Super Admin',
        'Admin',
        'Publisher',
        'Editor',
        'Reviewer',
        'Author',
        'User'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get roles
        $roles = DB::table('roles')->get();

        // Check existing roles
        foreach ($this->roles as $key => $role) {
            if (!in_array($role, $roles->map(function($r){return $r->name;})->toArray())) {
                // Create Role
                Role::create(['name' => $this->roles[$key]]);
            }
        }
    }

}