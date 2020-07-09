<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Status;
use App\User;

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
}
