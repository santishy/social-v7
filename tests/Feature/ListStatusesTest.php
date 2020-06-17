<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Status;

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
}
