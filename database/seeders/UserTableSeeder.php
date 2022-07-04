<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::where('first_name', 'Super')->exists()) {
            $user = new User();
            $user->first_name = "Super";
            $user->last_name = "Admin";
            $user->email = "superadmin@example.com";
            $user->password = bcrypt(12345678);
            $user->save();
        } else {
            $user = User::where('first_name', 'Super')->where('last_name', 'Admin')->first();
        }

        $role = Role::find(1);
        $user->assignRole($role);
        $user->update();

        $permissions = Permission::all();
        $roles = Role::all();
        foreach ($roles as $role) {
            if ($role->name == 'Super Admin' || $role->name == 'Admin') {
                $role->givePermissionTo($permissions);
            } elseif ($role->name == 'Publisher') {
                $role->givePermissionTo($permissions->whereIn('name', [
                    'users.create',
                    'users.show',
                    'users.edit',
                    'users.destroy',
                    'manuscripts.show',
                    'manuscripts.edit',
                    'manuscripts.destroy',
                    'manuscripts.publish',
                    'manuscripts.review',
                    'manuscripts.show_all',
                    'manuscripts.cover_letter',
                    'manuscripts.conflict_of_interest',
                    'manuscripts.declaration_of_interest_statement',
                    'journals.create',
                    'journals.show',
                    'journals.edit',
                    'journals.destroy',
                    'journals.show_all',
                    'dashboard.show',
                    'dashboard.show_all',
                    'dashboard.show_reviewers_status',
                ]));
            } elseif($role->name == 'Editor') {
                $role->givePermissionTo($permissions->whereIn('name', [
                    'manuscripts.show',
                    'manuscripts.edit',
                    'manuscripts.destroy',
                    'manuscripts.review',
                    'manuscripts.show_all',
                    'manuscripts.cover_letter',
                    'manuscripts.conflict_of_interest',
                    'manuscripts.declaration_of_interest_statement',
                    'journals.show',
                    'journals.edit',
                    'dashboard.show',
                    'dashboard.show_reviewers_status',
                ]));
            } elseif($role->name == 'Reviewer') {
                $role->givePermissionTo($permissions->whereIn('name', [
                    'manuscripts.show',
                    'manuscripts.edit',
                    'manuscripts.review',
                    'journals.show',
                    'journals.edit',
                    'dashboard.show',
                ]));
            } elseif($role->name == 'Author') {
                $role->givePermissionTo($permissions->whereIn('name', [
                    'manuscripts.show',
                    'manuscripts.edit',
                    'manuscripts.destroy',
                    'manuscripts.cover_letter',
                    'manuscripts.conflict_of_interest',
                    'manuscripts.declaration_of_interest_statement',
                    'journals.show',
                    'dashboard.show',
                ]));
            }
        }
    }
}
