<?php

namespace Tests\Unit\Http\Resources;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Comment;
use App\Htpp\Resources\CommentResource;

class CommentResourceTest extends TestCase
{
    /**
    *@test
    */
    public function a_comment_resources_have_must_the_necessary_fields(){
      $this->withoutExceptionHandling();
      $comment = factory(Comment::class)->create();
      $commentResource = CommentResource::make($comment);
      $this->assertEquals(
        $comment->body,
        $commentResource['body']
      );
    }
}
