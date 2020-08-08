<?php

namespace Tests\Unit\Http\Resources;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Comment;
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
        $comment->user->name,
        $commentResource['user_name']
      );
      $this->assertEquals(
        $comment->user->avatar(),
        $commentResource['user_avatar']
      );
      $this->assertEquals(
        false,
        $commentResource['is_liked']
      );
      $this->assertEquals(
        $comment->user->link(),
        $commentResource['user_link']
      );
      $this->assertEquals(
        $comment->id,
        $commentResource['id']
      );
      $this->assertEquals(
        0,
        $commentResource['likes_count']
      );
    }
}
