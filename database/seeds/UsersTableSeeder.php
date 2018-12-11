<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $password = bcrypt('test_34219_super_admin');

        DB::table('users')->insert(
            array(
                'name' => 'super_admin',
                'email' => 'test1@mail.com',
                'role_id' => 1,
                'password' => $password,
                'phone' => '12345',
                'partner_id' => 0,
                'image_id' => 0
            )
        );

        /*$password = bcrypt('test_34219_admin');

        DB::table('users')->insert(
            array(
                'name' => 'test_admin',
                'email' => 'test2@mail.com',
                'role_id' => 2,
                'password' => $password,
                'phone' => '12345',
                'partner_id' => 1,
                'image_id' => 0
            )
        );

        $password = bcrypt('test_34219_contributor');

        DB::table('users')->insert(
            array(
                'name' => 'test_contributor',
                'email' => 'test3@mail.com',
                'role_id' => 3,
                'password' => $password,
                'phone' => '12345',
                'partner_id' => 2,
                'image_id' => 0
            )
        );

        $password = bcrypt('api_access063');

        DB::table('users')->insert(
            array(
                'name' => 'api_user',
                'email' => 'api@questabout.com',
                'role_id' => 5,
                'password' => $password,
                'phone' => '12345',
                'partner_id' => 0,
                'image_id' => 0
            )
        );*/
    }
}
