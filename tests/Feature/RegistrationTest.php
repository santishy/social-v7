<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use App\User;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     *
     * @test
     */
    public function users_can_registration()
    {
        $this->withoutExceptionHandling();
        $userData = $this->validUserData();
        $response = $this->post(route('register'),$userData);
        $response->assertRedirect('/');
        $this->assertDatabaseHas('users',[
          'name' => 'SantiagoOchoa',
          'first_name' => 'Santiago',
          'last_name' => 'Ochoa',
          'email' => 'santi_shy@hotmail.com',
        ]);
        $this->assertTrue(
                            Hash::check('san10mar',User::first()->password),
                            'The password needs to be hashed'
                          );
    }

    /**
    *@test
    */

    function the_name_is_required(){
      $this->post(
                    route('register'),
                    $this->validUserData(['name' => ''])
                  )
                  ->assertSessionHasErrors(['name']);
    }

    public function validUserData($overrides = []){
      return array_merge([
                'name' => 'SantiagoOchoa',
                'first_name' => 'Santiago',
                'last_name' => 'Ochoa',
                'email' => 'santi_shy@hotmail.com',
                'password' => 'san10mar',
                'password_confirmation' => 'san10mar'
             ],$overrides);
    }
}
