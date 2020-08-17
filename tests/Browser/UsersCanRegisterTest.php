<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanRegisterTest extends DuskTestCase
{
    /**
    *@test
    */
    public function user_can_register(){
      $this->browse(function (Browser $browser){
          $browser->visit('/register')
                  ->type('name','santiagoOchoa')
                  ->type('first_name','santiago')
                  ->type('last_name','ochoa')
                  ->type('password','san10mar')
                  ->type('password_confirmation','san10mar')
                  ->press('@register-btn')
                  ->assertPathIs('/')
                  ->assertAuthenticated();
      });
    }
}
