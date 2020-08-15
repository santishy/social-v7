<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
        $userData = $this->userValidData();
        $response = $this->post(route('register'),$userData);
        $response->assertRedirect('/');
        $this->assertDatabaseHas('users',[
          'name' => 'SantiagoOchoa7',
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
                    $this->userValidData(['name' => ''])
                  )
                  ->assertSessionHasErrors(['name']);
    }

    /**
    *@test
    */
    public function the_name_must_be_a_string(){
      $this->post(
                    route('register'),
                    $this->userValidData(['name' => 2424])
                  )->assertSessionHasErrors(['name']);
    }

    /**
    *@test
    */
    public function the_name_may_not_be_greater_than_60_characters(){
      $this->post(
                    route('register'),
                    $this->userValidData(['name' => Str::random(61)])
                  )->assertSessionHasErrors(['name']);
    }

    /**
    *@test
    */
    function the_name_must_be_unique(){
      $user = factory(User::class)->create(['name' => 'santiago']);
      $this->post(
                    route('register'),
                    $this->userValidData(['name' => 'santiago'])
                  )->assertSessionHasErrors(['name']);
    }

    /**
    *@test
    */
    public function the_name_may_only_contain_letters_and_numbers(){
      $this->post(
                    route('register'),
                    $this->userValidData(['name' => 'santiago4*'])
                  )->assertSessionHasErrors(['name']);

      $this->post(
                    route('register'),
                    $this->userValidData(['name' => 'santiago OCHOA'])
                  )->assertSessionHasErrors(['name']);
    }

    /**
    *@test
    */
    public function the_name_must_be_at_least_3_characters(){
      $this->post(
                    route('register'),
                    $this->userValidData(['name' =>'ab'])
                  )->assertSessionHasErrors(['name']);
    }

    /**
    *@test
    */
    function the_first_name_is_required(){
      $this->post(
                    route('register'),
                    $this->userValidData(['first_name' => ''])
                  )
                  ->assertSessionHasErrors(['first_name']);
    }

    /**
    *@test
    */
    public function the_first_name_must_be_a_string(){
      $this->post(
                    route('register'),
                    $this->userValidData(['first_name' => 2424])
                  )->assertSessionHasErrors(['first_name']);
    }

    /**
    *@test
    */
    public function the_first_name_may_not_be_greater_than_60_characters(){
      $this->post(
                    route('register'),
                    $this->userValidData(['first_name' => Str::random(61)])
                  )->assertSessionHasErrors(['first_name']);
    }

    /**
    *@test
    */
    public function the_first_name_must_be_at_least_3_characters(){
      $this->post(
                    route('register'),
                    $this->userValidData(['first_name' =>'ab'])
                  )->assertSessionHasErrors(['first_name']);
    }

    /**
    *@test
    */
    public function the_first_name_may_only_contain_letters(){
      $this->post(
                    route('register'),
                    $this->userValidData(['first_name' => 'santiago4*'])
                  )->assertSessionHasErrors(['first_name']);

      $this->post(
                    route('register'),
                    $this->userValidData(['first_name' => 'santiago OCHOA'])
                  )->assertSessionHasErrors(['first_name']);
    }
    /**
    *@test
    */
    function the_last_name_is_required(){
      $this->post(
                    route('register'),
                    $this->userValidData(['last_name' => ''])
                  )
                  ->assertSessionHasErrors(['last_name']);
    }

    /**
    *@test
    */
    public function the_last_name_must_be_a_string(){
      $this->post(
                    route('register'),
                    $this->userValidData(['last_name' => 2424])
                  )->assertSessionHasErrors(['last_name']);
    }

    /**
    *@test
    */
    public function the_last_name_may_not_be_greater_than_60_characters(){
      $this->post(
                    route('register'),
                    $this->userValidData(['last_name' => Str::random(61)])
                  )->assertSessionHasErrors(['last_name']);
    }

    /**
    *@test
    */
    public function the_last_name_must_be_at_least_3_characters(){
      $this->post(
                    route('register'),
                    $this->userValidData(['last_name' =>'ab'])
                  )->assertSessionHasErrors(['last_name']);
    }

    /**
    *@test
    */
    public function the_last_name_may_only_contain_letters(){
      $this->post(
                    route('register'),
                    $this->userValidData(['last_name' => 'santiago4*'])
                  )->assertSessionHasErrors(['last_name']);

      $this->post(
                    route('register'),
                    $this->userValidData(['first_name' => 'santiago OCHOA'])
                  )->assertSessionHasErrors(['first_name']);
    }
    /**
    *@test
    */
    function the_email_is_required(){
      $this->post(
                    route('register'),
                    $this->userValidData(['email' => ''])
                  )
                  ->assertSessionHasErrors(['email']);
    }

    /**
    *@test
    */
    public function the_email_must_be__a_valid_email_address(){
      $this->post(
                    route('register'),
                    $this->userValidData(['email' => 'invalid@'])
                  )
                  ->assertSessionHasErrors(['email']);
    }

    /**
    *@test
    */
    public function the_email_must_be__unique(){
      $user = factory(User::class)->create(['email' => 'santi_shy@hotmail.com']);
      $this->post(
                    route('register'),
                    $this->userValidData()
                  )
                  ->assertSessionHasErrors(['email']);
    }

    /**
    *@test
    */
    function the_password_is_required(){
      $this->post(
                    route('register'),
                    $this->userValidData(['password' => ''])
                  )
                  ->assertSessionHasErrors(['password']);
    }

    /**
    *@test
    */
    public function the_password_must_be_a_string(){
      $this->post(
                    route('register'),
                    $this->userValidData(['password' => 2424])
                  )->assertSessionHasErrors(['password']);
    }

    /**
    *@test
    */
    public function the_password_must_be_at_least_8_characters(){
      $this->post(
                    route('register'),
                    $this->userValidData(['password' => '1234'])
                  )->assertSessionHasErrors(['password']);
    }

    /**
    *@test
    */
    public function the_password_must_be_confirmed(){
      $this->post(
                    route('register'),
                    $this->userValidData([
                                          'password' => 'san10mar',
                                          'password_confirmation' => null
                                         ])
                  )->assertSessionHasErrors(['password']);
    }

    public function userValidData($overrides = []){
      return array_merge([
                'name' => 'SantiagoOchoa7',
                'first_name' => 'Santiago',
                'last_name' => 'Ochoa',
                'email' => 'santi_shy@hotmail.com',
                'password' => 'san10mar',
                'password_confirmation' => 'san10mar'
             ],$overrides);
    }
}
