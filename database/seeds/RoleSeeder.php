<?php

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
        // Add roles

        DB::table('roles')->insert(
            array(
                'name' => 'global'
            )
        );

        DB::table('roles')->insert(
            array(
                'name' => 'admin'
            )
        );

        DB::table('roles')->insert(
            array(
                'name' => 'contributor'
            )
        );

        DB::table('roles')->insert(
            array(
                'name' => 'user'
            )
        );

        DB::table('roles')->insert(
            array(
                'name' => 'api'
            )
        );
    }
}
