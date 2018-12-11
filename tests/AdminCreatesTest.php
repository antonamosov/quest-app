<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminCreatesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    /**
         * My test implementation
         */
    public function testBasicExample()
    {
        // Login
        $this->visit('/login');
        $this->type('test1@mail.com', 'email');
        $this->type('test_34219_super_admin', 'password');
        $this->press('Login');

        // Domain
        $this->seePageIs('/admin');
        $this->visit('/admin/domain/create');
        $this->type('test_domain', 'slug');
        $this->press('Submit');
        $this->seePageIs('/admin/domain');


        //
        $this->visit('/admin/contributor');
        $this->visit('/admin/contributor/create');
        $this->type('berlin_contributor1', 'name');
        $this->type('berlin_contributor1@berlin.ru', 'email');
        $this->select('18', 'partner_id');
        $this->type('123', 'password');
        $this->type('123', 'password_confirm');
        $this->press('Submit');
        $this->seePageIs('/admin/contributor');
        $this->press('Edit');
        $this->seePageIs('/admin/contributor/edit/19');
        $this->type('berlin_contributor_test1', 'name');
        $this->press('Submit');
        $this->seePageIs('/admin/contributor');
    }

}
