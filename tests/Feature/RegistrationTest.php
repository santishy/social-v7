<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
      $userData = [
        'name' => 'Santiago',
        'email' => 'santi_shy@hotmail.com',
        'password' => 'san10mar',
        'password_confirmation' => 'san10mar'
      ];
      $response = $this->post(route('register'),$userData);
      $response->assertRedirect('/');
      $this->assertDatabaseHas('users',[
        'name' => 'Santiago',
        'email' => 'santi_shy@hotmail.com',
      ]);
    }
}
