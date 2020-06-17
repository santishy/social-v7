<?php

namespace Tests\Unit\Http\Resources;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Resources\StatusResource;
use App\Models\Status;

class StatusResourceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @test
     */
    public function a_status_resources_have_must_the_necessary_fields()
    {
        //$this->withoutExceptionHandling();
        $status = factory(Status::class)->create();
        $statusResource = StatusResource::make($status)->resolve();
        $this->assertEquals(
          $status->body,
          $statusResource['body']
        );
        $this->assertEquals(
          $status->user->name,
          $statusResource['user_name']
        );
        $this->assertEquals(
          'https://aprendible.com/images/default-avatar.jpg',
          $statusResource['user_avatar']
        );
        $this->assertEquals(
          $status->created_at->diffForHumans(),
          $statusResource['ago']
        );
        $this->assertArrayHasKey('body',$statusResource);
        $this->assertArrayHasKey('user_name',$statusResource);
        $this->assertArrayHasKey('user_avatar',$statusResource);
        $this->assertArrayHasKey('ago',$statusResource);
    }
}
