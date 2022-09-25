<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    protected $permissions = [
        'users' => [
            'create',
            'show',
            'edit',
            'destroy',
            'receive_notification_for_new_register_user'
        ],
        'settings' => [
            'show',
            'edit',
            'destroy'
        ],
        'manuscripts' => [
            'show',
            'edit',
            'destroy',
            'publish',
            'review',
            'show_all',
            'cover_letter',
            'conflict_of_interest',
            'declaration_of_interest_statement',
            'edit_after_submit',
        ],
        'journals' => [
            'create',
            'show',
            'edit',
            'destroy',
            'show_all'
        ],
        'dashboard' => [
            'show',
            'show_all',
            'show_reviewers_status'
        ],
        'roles_and_permissions' => [
            'edit'
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();

        // Create Users Permissions
        foreach ($this->permissions['users'] as $usersPermisson) {
            if (empty($permissions->where('name', "users.{$usersPermisson}")->first())) {
                Permission::create([
                    'name' => "users.{$usersPermisson}"
                ]);
            }
        }

        // Create Settings Permissions
        foreach ($this->permissions['settings'] as $usersPermisson) {
            if (empty($permissions->where('name', "settings.{$usersPermisson}")->first())) {
                Permission::create([
                    'name' => "settings.{$usersPermisson}"
                ]);
            }
        }

        // Create Manuscripts Permissions
        foreach ($this->permissions['manuscripts'] as $usersPermisson) {
            if (empty($permissions->where('name', "manuscripts.{$usersPermisson}")->first())) {
                Permission::create([
                    'name' => "manuscripts.{$usersPermisson}"
                ]);
            }
        }

        // Create Journals Permissions
        foreach ($this->permissions['journals'] as $usersPermisson) {
            if (empty($permissions->where('name', "journals.{$usersPermisson}")->first())) {
                Permission::create([
                    'name' => "journals.{$usersPermisson}"
                ]);
            }
        }

        // Create Dashboard Permissions
        foreach ($this->permissions['dashboard'] as $usersPermisson) {
            if (empty($permissions->where('name', "dashboard.{$usersPermisson}")->first())) {
                Permission::create([
                    'name' => "dashboard.{$usersPermisson}"
                ]);
            }
        }

        // Create Roles and Permissions Permissions
        foreach ($this->permissions['roles_and_permissions'] as $usersPermisson) {
            if (empty($permissions->where('name', "roles_and_permissions.{$usersPermisson}")->first())) {
                Permission::create([
                    'name' => "roles_and_permissions.{$usersPermisson}"
                ]);
            }
        }
    }
}
