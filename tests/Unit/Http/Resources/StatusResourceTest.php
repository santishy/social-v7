<?php

namespace Tests\Unit\Http\Resources;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Resources\StatusResource;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\User;
use App\Models\Status;
use App\Http\Resources\UserResource;

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
        $comment = factory(Comment::class)->create(['status_id' => $status->id]);
        $statusResource = StatusResource::make($status)->resolve();
        $this->assertEquals(
          $status->body,
          $statusResource['body']
        );
        $this->assertEquals(
          $status->created_at->diffForHumans(),
          $statusResource['ago']
        );
        $this->assertEquals(
          false,
          $statusResource['is_liked']
        );
        $this->assertEquals(
          0,
          $statusResource['likes_count']
        );
        //dd($statusResource['comments']->collection->first()->resource);
        $this->assertEquals(
          CommentResource::class,
          $statusResource['comments']->collects
        );
        $this->assertInstanceOf(
          Comment::class,
          $statusResource['comments']->first()->resource
        );
        //dd($statusResource['user']);
        $this->assertInstanceOf(
          UserResource::class,
          $statusResource['user']  //AQUI NO DEVUELVE UNA CADENA COMO CON EL METODO ->collects , devuelve una instancia del UserResource
        );
        $this->assertInstanceOf(
          User::class,
          $statusResource['user']->resource //aqui dentro de la instancia UserResource con el objeto ->resource (o llave) devuelve la instancia User::class
        );
        $this->assertArrayHasKey('body',$statusResource);
        $this->assertArrayHasKey('ago',$statusResource);
    }
}
