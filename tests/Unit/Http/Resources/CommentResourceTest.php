<?php

namespace Tests\Unit\Http\Resources;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Comment;
use App\Http\Resources\UserResource;
use App\User;
use App\Http\Resources\CommentResource;

class CommentResourceTest extends TestCase
{
    use RefreshDatabase;
    /**
    *@test
    */
    public function a_comment_resources_have_must_the_necessary_fields(){
      $this->withoutExceptionHandling();
      $comment = factory(Comment::class)->create();
      $commentResource = CommentResource::make($comment)->resolve();
      $this->assertEquals(
        $comment->body,
        $commentResource['body']
      );


      $this->assertEquals(
        false,
        $commentResource['is_liked']
      );
    
      $this->assertEquals(
        $comment->id,
        $commentResource['id']
      );
      $this->assertEquals(
        0,
        $commentResource['likes_count']
      );
      $this->assertInstanceOf(
        UserResource::class,
        $commentResource['user']  //AQUI NO DEVUELVE UNA CADENA COMO CON EL METODO ->collects , devuelve una instancia del UserResource
      );
      $this->assertInstanceOf(
        User::class,
        $commentResource['user']->resource //aqui dentro de la instancia UserResource con el objeto ->resource (o llave) devuelve la instancia User::class
      );
    }
}
