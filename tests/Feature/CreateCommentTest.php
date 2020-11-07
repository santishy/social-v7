<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Events\CommentCreated;
use App\Http\Resources\CommentResource;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use App\Models\Status;
use App\Models\Comment;
use App\User;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreateCommentTest extends TestCase
{
    use RefreshDatabase;
    /**
    *@test
    **/
    public function guests_users_cannot_comment_statuses(){

      $status = factory(Status::class)->create();
      $response = $this->postJson(route('statuses.comments.store',$status),['body' => 'Mi primer comentario']);
      $response->assertStatus(401);
    }
    /**
    *@test
    */
    public function authenticated_users_can_comment_statuses()
    {
      $this->withoutExceptionHandling();
      $status = factory(Status::class)->create();
      $user = factory(User::class)->create();
      $this->actingAs($user);
      $response = $this->postJson(route('statuses.comments.store',$status),['body' => 'Mi primer comentario']);
      $response->assertJson(['data' => ['body' => 'Mi primer comentario']]);
      $this->assertDatabaseHas('comments',[
        'user_id' => $user->id,
        'status_id' => $status->id,
        'body' => 'Mi primer comentario',
      ]);
    }
    /**
     * @test
     */
    public function an_event_fired_when_a_comment_is_created(){
      Event::fake([CommentCreated::class]);
      Broadcast::shouldReceive('socket')->andReturn('socket-id');
      $status = factory(Status::class)->create();
      $user = factory(User::class)->create();
      $this->actingAs($user)->postJson(route('statuses.comments.store',$status),['body' => 'status commented']);
      Event::assertDispatched(CommentCreated::class,function($e){ 
        //$this->assertInstanceof(\Illuminate\Broadcasting\Channel::class,$e->broadcastOn()); // ESTE ASSERT NO ES PRECISO YA QUE , SI PONGO UN privateChannel me daria true por que privateChannel implementa la clase Channel
        $this->assertEventChannelType('public',$e);
        $this->assertEventChannelName('statuses.'.$e->comment->id.'.comments',$e);
        $this->assertInstanceOf(CommentResource::class,$e->comment);
        /*$this->assertEquals(Status::first()->id,$e->status->id);
        $this->assertInstanceOf(Status::class,$e->status->resource); ESTAS DOS LINEAS SON REEMPLAZADAS CON $this->assertTrue(Status::first()->is($e->status->resource));*/
        $this->assertTrue(Comment::first()->is($e->comment->resource));
        $this->assertDontBroadcastToCurrentUser($e);
        return true;
      });

    }
    /**
    *@test
    */
    public function a_comment_requires_a_body(){
      $user = factory(User::class)->create();
      $status = factory(Status::class)->create();
      $this->actingAs($user);
      $response = $this->postJson(route('statuses.comments.store',$status),['body' => '']);
      $response->assertStatus(422);
      $response->assertJsonStructure([
        'message',
        'errors'=>['body']
      ]);
    }
}
