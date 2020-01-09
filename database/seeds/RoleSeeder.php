<?php

use App\Role;
use App\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            [
                "name" => "Developer",
                "slug" => "developer"
            ],
            [
                "name" => "Admin",
                "slug" => "admin"
            ],
        ]);

        $developerRole = Role::developer()->firstOrFail();
        $developerPermissions = Permission::whereIn('slug', ['view-developer-dashboard'])->get()->pluck('id')->toArray();
        $developerRole->permissions()->sync($developerPermissions);
    }
}
