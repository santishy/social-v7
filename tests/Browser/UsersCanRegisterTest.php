<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersCanRegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
    *@test
    */
    public function user_can_register(){
      $this->browse(function (Browser $browser){
          $browser->visit('/register')
                  ->type('name','santiagoOchoa')
                  ->type('first_name','santiago')
                  ->type('last_name','ochoa')
                  ->type('email','santi_shy@hotmail.com')
                  ->type('password','san10mar')
                  ->type('password_confirmation','san10mar')
                  ->press('@register-btn')
                  ->assertPathIs('/')
                  ->assertAuthenticated();
      });
    }

    /**
    *@test AQUI NO SE MANDAN TODOS LOS CAMPOS INVALIDOS, POR QUE YA LOS VIMOS EN FEATURES Y QUEREMOS VER SOLO EL ELEMENTO ERRORS
    */
    public function user_cannot_register_with_invalid_information(){
      $this->browse(function (Browser $browser){
          $browser->visit('/register')
                  ->type('name','')
                  ->press('@register-btn')
                  ->assertPathIs('/register')
                  ->assertPresent('@validation-errors');
      });
    }
}
