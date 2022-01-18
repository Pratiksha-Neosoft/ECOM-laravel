<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([[
            'role_name'=>'superadmin'
        ],[
            'role_name'=>'admin'
        ],[
            'role_name'=>'inventory manager'
        ],[
            'role_name'=>'order manager'
        ],[
            'role_name'=>'customer'
        ]]);
    }
}
