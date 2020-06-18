<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Models\Status;

class CanLikeStatusesTest extends TestCase
{

  use RefreshDatabase;

  /** @test */
  public function an_authenticated_user_can_like_statuses(){
    $this->withoutExceptionHandling();
    $user = factory(User::class)->create();
    $status = factory(Status::class)->create();
    $this->actingAs($user)->postJson(route('statuses.likes.store',$status));
    $this->assertDatabaseHas('likes',[
      'user_id' => $user->id,
      'status_id' => $status->id
    ]);
  }
}
