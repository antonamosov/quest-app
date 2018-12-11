<?php

use Illuminate\Database\Seeder;

class popularCategory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert(
            array(
                'id' => 1,
                'name' => 'Popular',
                'description' => 'Popular',
                'image_id' => 0,
                'user_id' => 0,
                'is_virtual' => 1
            )
        );
    }
}



