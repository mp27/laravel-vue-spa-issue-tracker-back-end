<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert([
            [
                "name" => "View developer dashboard",
                "slug" => "view-developer-dashboard"
            ],
            [
                "name" => "View admin dashboard",
                "slug" => "view-admin-dashboard"
            ]
        ]);
    }
}
