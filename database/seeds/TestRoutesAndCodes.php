<?php

use Illuminate\Database\Seeder;

class TestRoutesAndCodes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Routes
         */

        DB::table('routes')->insert(
            array(
                'id' => 100,
                'description' => 'Popular tour around Sydney historical sites',
                'image_id' => 100,
                'price' => '8.99',
                'category_id' => 100,
                'contributor_id' => 3,
                'name' => 'Sydney City popular sites',
                'user_id' => 2
            )
        );

        DB::table('routes')->insert(
            array(
                'id' => 101,
                'description' => 'Tour starts at Museum train station',
                'image_id' => 101,
                'price' => '5.99',
                'category_id' => 101,
                'contributor_id' => 3,
                'name' => 'Guide Park Walking Tour',
                'user_id' => 100
            )
        );

        /*
         * Categories
         */

        DB::table('categories')->insert(
            array(
                'id' => 100,
                'description' => 'Exploring the central parts of Historical Sydney CBD',
                'name' => 'Central Sydney Walking Tours',
                'user_id' => 2,
                'image_id' => 102
            )
        );

        DB::table('categories')->insert(
            array(
                'id' => 101,
                'description' => 'subway',
                'name' => 'Metropolian',
                'user_id' => 100,
                'image_id' => 103
            )
        );

        /*
         * Points
         */

        DB::table('points')->insert(
            array(
                'id' => 100,
                'route_id' => 100,
                'image_id' => 104,
                'number' => 1,
                'coordinates' => '-33.869806, 151.211527',
                'question_id' => 100,
                'how_to_get' => 'Start: St James Station. It’s City Circle line station on the edge of Hyde Park.',
                'btw' => 'did you know the name of first Mayor?',
                'name' => 'stj-station',
            )
        );

        DB::table('points')->insert(
            array(
                'id' => 101,
                'route_id' => 100,
                'image_id' => 105,
                'number' => 2,
                'coordinates' => '61.782128, 34.349315',
                'question_id' => 101,
                'how_to_get' => 'From the northern entrance of St James Station on Elizabeth Street go to the corner of Elizabeth St and Market St. David Jones\' flagship building is located here.',
                'btw' => 'Look around and arond',
                'name' => 'David Jones department store'
            )
        );

        DB::table('points')->insert(
            array(
                'id' => 102,
                'route_id' => 100,
                'image_id' => 106,
                'number' => 3,
                'coordinates' => '61.782128, 34.349315',
                'question_id' => 102,
                'how_to_get' => 'Walk down Elizabeth St. On the corner of King St and Elizabeth St on your right you will see the Old Supreme Court.',
                'btw' => '',
                'name' => 'The Old Supreme Court'
            )
        );

        DB::table('points')->insert(
            array(
                'id' => 103,
                'route_id' => 100,
                'image_id' => 107,
                'number' => 4,
                'coordinates' => '61.782128, 34.349315',
                'question_id' => 103,
                'how_to_get' => 'Walk down Elizabeth Street until you reach Martin Place.',
                'btw' => '',
                'name' => 'Martin Place'
            )
        );

        DB::table('points')->insert(
            array(
                'id' => 104,
                'route_id' => 100,
                'image_id' => 108,
                'number' => 5,
                'coordinates' => '61.782128, 34.349315',
                'question_id' => 104,
                'how_to_get' => 'From the corner of Elizabeth St and Martin Pl turn left and walk along Martin Pl. Cross Castlereagh St and go to the corner of Martin Pl and Pitt St. Here you will see an imposing 12-storey building.',
                'btw' => '',
                'name' => 'CBA building'
            )
        );

        DB::table('points')->insert(
            array(
                'id' => 105,
                'route_id' => 101,
                'image_id' => 100,
                'number' => 1,
                'coordinates' => '61.782128, 34.349315',
                'question_id' => 104,
                'how_to_get' => 'test how to get',
                'btw' => '',
                'name' => 'test route name 1'
            )
        );

        DB::table('points')->insert(
            array(
                'id' => 106,
                'route_id' => 101,
                'image_id' => 101,
                'number' => 2,
                'coordinates' => '-33.869806, 151.211527',
                'question_id' => 105,
                'how_to_get' => 'test how to get.',
                'btw' => 'test btw',
                'name' => 'test route name 2'
            )
        );

        /*
         * Questions
         */

        DB::table('questions')->insert(
            array(
                'id' => 100,
                'paragraph' => 'Whatever we see whatever w choose',
                'question' => 'How many legs this sculpture has ?',
                'user_id' => 2,
                'image_id' => 100
            )
        );


        DB::table('questions')->insert(
            array(
                'id' => 101,
                'paragraph' => 'What happens in nz stays in nz',
                'question' => 'Where is nz?',
                'user_id' => 2,
                'image_id' => 101
            )
        );

        DB::table('questions')->insert(
            array(
                'id' => 102,
                'paragraph' => 'Where is Australia?',
                'question' => 'Where is the actual location of Sydney?',
                'user_id' => 2,
                'image_id' => 102
            )
        );

        DB::table('questions')->insert(
            array(
                'id' => 103,
                'paragraph' => 'Question paragraph',
                'question' => 'One Plus 3 equal ?',
                'user_id' => 2,
                'image_id' => 103
            )
        );

        DB::table('questions')->insert(
            array(
                'id' => 104,
                'paragraph' => 'Opening paragraph',
                'question' => 'How many letters in the word TEST',
                'user_id' => 2,
                'image_id' => 104
            )
        );

        DB::table('questions')->insert(
            array(
                'id' => 105,
                'paragraph' => '',
                'question' => '',
                'user_id' => 2,
                'image_id' => 105
            )
        );

        DB::table('questions')->insert(
            array(
                'id' => 106,
                'paragraph' => '',
                'question' => '',
                'user_id' => 2,
                'image_id' => 106
            )
        );

        /*
         * Hints
         */

        DB::table('hints')->insert(
            array(
                'id' => 100,
                'name' => 'when was it built?',
                'point_id' => 100,
                'order' => 1,
                'question_id' => 100
            )
        );

        DB::table('hints')->insert(
            array(
                'id' => 101,
                'name' => 'check the newspaper',
                'point_id' => 100,
                'order' => 2,
                'question_id' => 100
            )
        );

        DB::table('hints')->insert(
            array(
                'id' => 102,
                'name' => 'how did you wake up today?',
                'point_id' => 100,
                'order' => 3,
                'question_id' => 100
            )
        );



        DB::table('hints')->insert(
            array(
                'id' => 104,
                'name' => 'Less than 5',
                'point_id' => 101,
                'order' => 1,
                'question_id' => 101
            )
        );

        DB::table('hints')->insert(
            array(
                'id' => 105,
                'name' => 'Very far',
                'point_id' => 101,
                'order' => 2,
                'question_id' => 101
            )
        );

        DB::table('hints')->insert(
            array(
                'id' => 106,
                'name' => 'when was it built?',
                'point_id' => 102,
                'order' => 1,
                'question_id' => 102
            )
        );

        DB::table('hints')->insert(
            array(
                'id' => 107,
                'name' => 'check the newspaper',
                'point_id' => 102,
                'order' => 2,
                'question_id' => 102
            )
        );

        DB::table('hints')->insert(
            array(
                'id' => 108,
                'name' => 'how did you wake up today?',
                'point_id' => 102,
                'order' => 3,
                'question_id' => 102
            )
        );

        DB::table('hints')->insert(
            array(
                'id' => 109,
                'name' => 'Less than 5',
                'point_id' => 103,
                'order' => 1,
                'question_id' => 103
            )
        );

        DB::table('hints')->insert(
            array(
                'id' => 103,
                'name' => 'More than 3',
                'point_id' => 104,
                'order' => 1,
                'question_id' => 104
            )
        );

        /*
         * Answers test1, test2, test3, TEST5, TEST6, test7, test8, test9
         */

        DB::table('answers')->insert(
            array(
                'id' => 100,
                'name' => 'test1',
                'user_id' => 2,
                'question_id' => 100,
                'point_id' => 100
            )
        );

        DB::table('answers')->insert(
            array(
                'id' => 101,
                'name' => 'test2',
                'user_id' => 2,
                'question_id' => 100,
                'point_id' => 100
            )
        );

        DB::table('answers')->insert(
            array(
                'id' => 102,
                'name' => 'test3',
                'user_id' => 2,
                'question_id' => 100,
                'point_id' => 100
            )
        );

        DB::table('answers')->insert(
            array(
                'id' => 103,
                'name' => 'test4',
                'user_id' => 2,
                'question_id' => 100,
                'point_id' => 100
            )
        );

        DB::table('answers')->insert(
            array(
                'id' => 104,
                'name' => 'test5',
                'user_id' => 2,
                'question_id' => 100,
                'point_id' => 100
            )
        );

        DB::table('answers')->insert(
            array(
                'id' => 105,
                'name' => 'test6',
                'user_id' => 2,
                'question_id' => 101,
                'point_id' => 101
            )
        );

        DB::table('answers')->insert(
            array(
                'id' => 106,
                'name' => 'test7',
                'user_id' => 2,
                'question_id' => 101,
                'point_id' => 101
            )
        );

        DB::table('answers')->insert(
            array(
                'id' => 107,
                'name' => 'test8',
                'user_id' => 2,
                'question_id' => 101,
                'point_id' => 101
            )
        );

        DB::table('answers')->insert(
            array(
                'id' => 108,
                'name' => 'test9',
                'user_id' => 2,
                'question_id' => 102,
                'point_id' => 102
            )
        );

        DB::table('answers')->insert(
            array(
                'id' => 109,
                'name' => 'test1',
                'user_id' => 2,
                'question_id' => 102,
                'point_id' => 102
            )
        );

        DB::table('answers')->insert(
            array(
                'id' => 110,
                'name' => 'test2',
                'user_id' => 2,
                'question_id' => 102,
                'point_id' => 102
            )
        );

        DB::table('answers')->insert(
            array(
                'id' => 111,
                'name' => 'test3',
                'user_id' => 2,
                'question_id' => 103,
                'point_id' => 103
            )
        );

        DB::table('answers')->insert(
            array(
                'id' => 112,
                'name' => 'test4',
                'user_id' => 2,
                'question_id' => 104,
                'point_id' => 104
            )
        );

        DB::table('answers')->insert(
            array(
                'id' => 113,
                'name' => 'test5',
                'user_id' => 2,
                'question_id' => 105,
                'point_id' => 105
            )
        );

        DB::table('answers')->insert(
            array(
                'id' => 114,
                'name' => 'test6',
                'user_id' => 2,
                'question_id' => 106,
                'point_id' => 106
            )
        );

        /*
         * Codes
         */



        $pswrd = '3YjbBI';
        DB::table('codes')->insert(
            array(
                'id' => 100,
                'user_id' => 2,
                'route_id' => 100,
                'payment_id' => 0,
                'point_id' => 0,
                'active' => true,
                'email_or_phone'=> 's.maket@ya.ru',
                'type' => 'email',
                'name_crypt' => bcrypt($pswrd),
                'name' => $pswrd
            )
        );

        $pswrd = '3gXfOF';
        DB::table('codes')->insert(
            array(
                'id' => 101,
                'user_id' => 2,
                'route_id' => 100,
                'payment_id' => 0,
                'point_id' => 0,
                'active' => true,
                'email_or_phone'=> 's.maket@ya.ru',
                'type' => 'email',
                'name_crypt' => bcrypt($pswrd),
                'name' => $pswrd
            )
        );

        $pswrd = 'pji4YL';
        DB::table('codes')->insert(
            array(
                'id' => 102,
                'user_id' => 2,
                'route_id' => 100,
                'payment_id' => 0,
                'point_id' => 0,
                'active' => true,
                'email_or_phone'=> 's.maket@ya.ru',
                'type' => 'email',
                'name_crypt' => bcrypt($pswrd),
                'name' => $pswrd
            )
        );

        $pswrd = 'U6Z0jE';
        DB::table('codes')->insert(
            array(
                'id' => 103,
                'user_id' => 2,
                'route_id' => 100,
                'payment_id' => 0,
                'point_id' => 0,
                'active' => true,
                'email_or_phone'=> 's.maket@ya.ru',
                'type' => 'email',
                'name_crypt' => bcrypt($pswrd),
                'name' => $pswrd
            )
        );

        $pswrd = 'cqiTVY';
        DB::table('codes')->insert(
            array(
                'id' => 104,
                'user_id' => 2,
                'route_id' => 100,
                'payment_id' => 0,
                'point_id' => 0,
                'active' => true,
                'email_or_phone'=> 's.maket@ya.ru',
                'type' => 'email',
                'name_crypt' => bcrypt($pswrd),
                'name' => $pswrd
            )
        );

        $pswrd = '1FYLpU';
        DB::table('codes')->insert(
            array(
                'id' => 105,
                'user_id' => 2,
                'route_id' => 101,
                'payment_id' => 0,
                'point_id' => 0,
                'active' => true,
                'email_or_phone'=> 's.maket@ya.ru',
                'type' => 'email',
                'name_crypt' => bcrypt($pswrd),
                'name' => $pswrd
            )
        );

        $pswrd = '67xgMx';
        DB::table('codes')->insert(
            array(
                'id' => 106,
                'user_id' => 2,
                'route_id' => 101,
                'payment_id' => 0,
                'point_id' => 0,
                'active' => true,
                'email_or_phone'=> 's.maket@ya.ru',
                'type' => 'email',
                'name_crypt' => bcrypt($pswrd),
                'name' => $pswrd
            )
        );

        $pswrd = 'wFvRuE';
        DB::table('codes')->insert(
            array(
                'id' => 107,
                'user_id' => 2,
                'route_id' => 101,
                'payment_id' => 0,
                'point_id' => 0,
                'active' => true,
                'email_or_phone'=> 's.maket@ya.ru',
                'type' => 'email',
                'name_crypt' => bcrypt($pswrd),
                'name' => $pswrd
            )
        );

        $pswrd = 'oqvmuG';
        DB::table('codes')->insert(
            array(
                'id' => 108,
                'user_id' => 2,
                'route_id' => 101,
                'payment_id' => 0,
                'point_id' => 0,
                'active' => false,
                'email_or_phone'=> 's.maket@ya.ru',
                'type' => 'email',
                'name_crypt' => bcrypt($pswrd),
                'name' => $pswrd
            )
        );

        $pswrd = '97qNP9';
        DB::table('codes')->insert(
            array(
                'id' => 109,
                'user_id' => 2,
                'route_id' => 101,
                'payment_id' => 0,
                'point_id' => 0,
                'active' => true,
                'email_or_phone'=> 's.maket@ya.ru',
                'type' => 'email',
                'name_crypt' => bcrypt($pswrd),
                'name' => $pswrd
            )
        );

        $pswrd = 'dWaRtL';
        DB::table('codes')->insert(
            array(
                'id' => 110,
                'user_id' => 2,
                'route_id' => 101,
                'payment_id' => 0,
                'point_id' => 0,
                'active' => false,
                'email_or_phone'=> 's.maket@ya.ru',
                'type' => 'email',
                'name_crypt' => bcrypt($pswrd),
                'name' => $pswrd
            )
        );

        $pswrd = 'dUB42W';
        DB::table('codes')->insert(
            array(
                'id' => 111,
                'user_id' => 2,
                'route_id' => 101,
                'payment_id' => 0,
                'point_id' => 0,
                'active' => true,
                'email_or_phone'=> '+79112223344',
                'type' => 'phone',
                'name_crypt' => bcrypt($pswrd),
                'name' => $pswrd
            )
        );

        $pswrd = 'hbi5CD';
        DB::table('codes')->insert(
            array(
                'id' => 112,
                'user_id' => 2,
                'route_id' => 100,
                'payment_id' => 0,
                'point_id' => 0,
                'active' => true,
                'email_or_phone'=> 's.maket@ya.ru',
                'type' => 'email',
                'name_crypt' => bcrypt($pswrd),
                'name' => $pswrd
            )
        );

        $pswrd = 'UTl01Q';
        DB::table('codes')->insert(
            array(
                'id' => 113,
                'user_id' => 2,
                'route_id' => 100,
                'payment_id' => 0,
                'point_id' => 0,
                'active' => true,
                'email_or_phone'=> 's.maket@ya.ru',
                'type' => 'email',
                'name_crypt' => bcrypt($pswrd),
                'name' => $pswrd
            )
        );

        /*
         * Additional
         */

        /*
         * Domain
         */

        DB::table('domains')->insert(
            array(
                'id' => 100,
                'slug' => 'london'
            )
        );

        /*
         * partner
         */

        DB::table('partners')->insert(
            array(
                'id' => 100,
                'name' => 'Main partner',
                'domain_id' => 1,
                'user_id' => 2
            )
        );

        DB::table('partners')->insert(
            array(
                'id' => 101,
                'name' => 'London partner',
                'domain_id' => 100,
                'user_id' => 100
            )
        );

        /*
         * Admin
         */

        $pswrd = 'london-quest-111';

        DB::table('users')->insert(
            array(
                'id' => 100,
                'name' => 'London admin',
                'email' => 'london@quest.com',
                'password' => bcrypt($pswrd),
                'partner_id' => 0,
                'phone' => 0,
                'image_id' => 0,
                'role_id' => 2,
            )
        );

        /*
         * Landing
         */


        DB::table('landings')->insert(
            array(
                'id' => 100,
                'logo_image_id' => 110,
                'main_image_id' => 111,
                'header' => 'test',
                'background' => 'rgba(217, 42, 42, 0.12)',
                'faq' => 'test',
                'user_id' => 100,
                'domain_id' => 100
            )
        );

        /*
         * Images
         */

        DB::table('images')->insert(
            array(
                'id' => 100,
                'path' => '/test_images/1.jpg'
            )
        );

        DB::table('images')->insert(
            array(
                'id' => 101,
                'path' => '/test_images/2.jpg'
            )
        );

        DB::table('images')->insert(
            array(
                'id' => 102,
                'path' => '/test_images/3.jpg'
            )
        );

        DB::table('images')->insert(
            array(
                'id' => 103,
                'path' => '/test_images/4.jpg'
            )
        );

        DB::table('images')->insert(
            array(
                'id' => 104,
                'path' => '/test_images/5.jpg'
            )
        );

        DB::table('images')->insert(
            array(
                'id' => 105,
                'path' => '/test_images/6.jpg'
            )
        );

        DB::table('images')->insert(
            array(
                'id' => 106,
                'path' => '/test_images/7.jpg'
            )
        );

        DB::table('images')->insert(
            array(
                'id' => 107,
                'path' => '/test_images/1.jpg'
            )
        );

        DB::table('images')->insert(
            array(
                'id' => 108,
                'path' => '/test_images/2.jpg'
            )
        );

        DB::table('images')->insert(
            array(
                'id' => 109,
                'path' => '/test_images/3.jpg'
            )
        );

        DB::table('images')->insert(
            array(
                'id' => 110,
                'path' => '/test_images/4.jpg'
            )
        );

        DB::table('images')->insert(
            array(
                'id' => 111,
                'path' => '/test_images/5.jpg'
            )
        );

        DB::table('images')->insert(
            array(
                'id' => 112,
                'path' => '/test_images/6.jpg'
            )
        );

        DB::table('images')->insert(
            array(
                'id' => 113,
                'path' => '/test_images/7.jpg'
            )
        );

        DB::table('images')->insert(
            array(
                'id' => 114,
                'path' => '/test_images/1.jpg'
            )
        );

        DB::table('images')->insert(
            array(
                'id' => 115,
                'path' => '/test_images/2.jpg'
            )
        );

        DB::table('images')->insert(
            array(
                'id' => 116,
                'path' => '/test_images/3.jpg'
            )
        );

        DB::table('images')->insert(
            array(
                'id' => 117,
                'path' => '/test_images/4.jpg'
            )
        );

        DB::table('images')->insert(
            array(
                'id' => 118,
                'path' => '/test_images/5.jpg'
            )
        );
    }
}
