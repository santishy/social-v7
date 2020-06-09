<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;

class LoginTest extends DuskTestCase
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
                    ->press('#login-btn')
                    ->assertPathIs('/')
                    ->assertAuthenticated();
        });
    }
}
