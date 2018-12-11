<?php

use Illuminate\Database\Seeder;

class AmosaaUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = bcrypt('123123123');

        DB::table('users')->insert(
            array(
                'name' => 'amosaa',
                'email' => 'amosaa@mail.ru',
                'role_id' => 1,
                'password' => $password,
                'phone' => '+79814078157',
                'partner_id' => 0,
                'image_id' => 0
            )
        );
    }
}
