<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_user')->insert([
            'name' => 'magoxrer',
            'org_id'=>1,
            'mobile' => '13388888888',
            'password' => bcrypt('123456'),
            'username' => str_random(10),
            'nikename' => str_random(10),
            'avatar' =>str_random(10),
            'invitation_code'=>str_random(10),
            'status'=>1
        ]);
        DB::table('admin_menu')->insert([
            'org_id' => 'magoxrer',
            'parent_id'=>0,
            'title'=>'系统管理',
            'icon'=>'fa-css',
            'uri'=>'uri/abc',
        ]);
    }
}
