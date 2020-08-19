<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Status;
use App\User;

class ListStatusesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function can_get_all_statuses()
    {
        $this->withoutExceptionHandling();
        $status1 = factory(Status::class)->create(['created_at' => now()->subDays(4)]);
        $status2 = factory(Status::class)->create(['created_at' => now()->subDays(3)]);
        $status3 = factory(Status::class)->create(['created_at' => now()->subDays(2)]);
        $status4 = factory(Status::class)->create(['created_at' => now()->subDays(1)]);
        $response = $this->getJson(route('statuses.index'));
        $response->assertSuccessFul();

        $response->assertJson([
          'meta'=> ['total' => 4]
        ]);
        $response->assertJsonStructure([
          'links'=>['next','prev'],'data'
        ]);
        $this->assertEquals($response->json('data.0.body'),$status4->body);
        $response->assertStatus(200);
    }

    /**
    *@test
    */
    public function can_get_statuses_for_a_specific_user(){
      $this->withoutExceptionHandling();
      $user = factory(User::class)->create();
      $status1 = factory(Status::class)->create(['created_at' => now()->subDay(),'user_id' => $user->id]);
      $status2 = factory(Status::class)->create(['user_id' => $user->id]);
      $otherStatuses = factory(Status::class,2)->create();
      $response = $this->actingAs($user)
                       ->getJson(route('users.statuses.index',$user));
      $response->assertJson([
        'meta' => ['total' => 2]
      ]);
      $response->assertJsonStructure([
        'links' => [
          'next','prev'
        ], 'data'
      ]);
      $this->assertEquals($response->json('data.0.body'),$status2->body);
    }

}
