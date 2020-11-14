<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Events\StatusCreated;

use App\Http\Resources\StatusResource;
use App\Models\Status;
use Illuminate\Broadcasting\Broadcasters\Broadcaster;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Event;


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
      
      $user = factory(User::class)->create();
      $this->actingAs($user);
      $response = $this->postJson(route('statuses.store'),['body' => 'Mi primer estado']);
      $response->assertJson(['data' => ['body' => 'Mi primer estado']]);
      $this->assertDatabaseHas('statuses',[
                                            'body' => 'Mi primer estado',
                                            'user_id' => $user->id
                                          ]);
    }
    /**
     * @test
     */
    public function an_event_is_fired_when_a_status_is_created(){
      Event::fake([Statuscreated::class]); // esto evita que ejecuten todos los listeners de la app
      Broadcast::shouldReceive('socket')->andReturn('socket-id');
      $user = factory(User::class)->create();
       $this->actingAs($user)->postJson(route('statuses.store'),['body' => 'Mi primer estado']);
      Event::assertDispatched(StatusCreated::class,function($e){
      
       
        $this->assertInstanceof(\Illuminate\Broadcasting\Channel::class,$e->broadcastOn()); // ESTE ASSERT NO ES PRECISO YA QUE , SI PONGO UN privateChannel me daria true por que privateChannel implementa la clase Channel
        $this->assertEventChannelType('public',$e);
        $this->assertEventChannelName('statuses',$e);
        $this->assertInstanceOf(StatusResource::class,$e->status);
        /*$this->assertEquals(Status::first()->id,$e->status->id);
        $this->assertInstanceOf(Status::class,$e->status->resource); */
        $this->assertTrue(Status::first()->is($e->status->resource));
        $this->assertDontBroadcastToCurrentUser($e);
        return true;
      });
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
