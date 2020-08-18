<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;

class UsersCanLoginTest extends DuskTestCase
{
   use DatabaseMigrations;
   /** @test */
    public function registered_users_can_login()
    {
        factory(User::class)->create(['email' => 'santi_shy@hotmail.com']);
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email','santi_shy@hotmail.com')
                    ->type('password','password')
                    ->press('@login-btn')
                    ->assertPathIs('/')
                    ->assertAuthenticated();
        });
    }

    /**
    *@test AQUI NO SE MANDAN TODOS LOS CAMPOS INVALIDOS, POR QUE YA LOS VIMOS EN FEATURES Y QUEREMOS VER SOLO EL ELEMENTO ERRORS
    */
    public function user_cannot_login_with_invalid_information(){
      $this->browse(function (Browser $browser){
          $browser->visit('/login')
                  ->type('email','')
                  ->press('@login-btn')
                  ->assertPathIs('/login')
                  ->assertPresent('@validation-errors');
      });
    }
}
