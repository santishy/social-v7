<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class CreateStatusTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function an_authenticated_user_can_crate_statuses()
    {
      $this->withoutExceptionHandling();
      $user = factory(User::class)->create();
      $this->actingAs($user);
      $response = $this->postJson(route('statuses.store'),['body' => 'Mi primer estado']);
      $response->assertJson(['body' => 'Mi primer estado']);
      $this->assertDatabaseHas('statuses',[
                                            'body' => 'Mi primer estado',
                                            'user_id' => $user->id
                                          ]);
    }

    /**
    *
    *@test
    *
    */
    public function guests_can_not_create_statuses(){

        $response = $this->post(route('statuses.store'),['body' => 'Mi primer estado']);

        $response->assertRedirect('login');
    }
    /**
    *
    *@test
    */
    public function a_status_require_a_body(){
      $user = factory(User::class)->create();
      $this->actingAs($user);
      $response = $this->postJson(route('statuses.store'),['body' => '']);
      $response->assertStatus(422); // es un estatus de entidad no procesable
      $response->assertJsonStructure([
        'message','errors'=>['body']
      ]);

    }
    /** @test */
    public function a_status_body_requires_a_minimum_length(){
      $user = factory(User::class)->create();
      $this->actingAs($user);
      $response = $this->postJson(route('statuses.store'),['body' => 'asdf']);
      $response->assertStatus(422); // es un estatus de entidad no procesable
      $response->assertJsonStructure([
        'message','errors'=>['body']
      ]);
    }
}
