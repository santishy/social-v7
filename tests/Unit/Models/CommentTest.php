<?php

namespace Tests\Unit\Models;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use App\Models\Status;
use Tests\TestCase;
use App\User;
use App\Models\Like;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    /**
    *@test
    */
    public function a_comment_belongs_to_user(){
      $status = factory(Status::class)->create();
      $comment = factory(Comment::class)->create(['status_id' => $status->id]);
      $this->assertInstanceOf(User::class,$comment->user);
    }
    /**
    *@test
    */
    public function a_comment_morph_many_likes(){
      $comment = factory(Comment::class)->create();
      $like = factory(Like::class)->create([
        'likeable_id' => $comment->id,
        'likeable_type' => get_class($comment),
      ]);
      $this->assertInstanceOf(Like::class,$comment->likes()->first());
    }
    /** @test */
    public function a_comment_can_be_liked_and_unlike(){
      $comment = factory(Comment::class)->create();
      $this->actingAs(factory(User::class)->create());
      $this->assertInstanceOf(Like::class,$comment->like());
      $this->assertEquals(1,$comment->likes->count());
      $comment->unliked();
      $this->assertEquals(0,$comment->fresh()->likes->count());
    }
    /** @test */
    public function a_comment_knows_if_it_been_liked(){
      $comment = factory(Comment::class)->create();
      $this->actingAs(factory(User::class)->create());
      $comment->like();
      $this->assertTrue($comment->isLiked());
      $comment->fresh()->unliked();
      $this->assertFalse($comment->isLiked());
    }
    /** @test */
    public function a_comment_knows_how_many_likes_it_has(){
      $comment = factory(Comment::class)->create();
      $this->assertEquals(0,$comment->likesCount());
      factory(Like::class,2)->create([
                                      'likeable_id' => $comment->id,
                                      'likeable_type' => get_class($comment)
                                    ]);
      $this->assertEquals(2,$comment->fresh()->likesCount());
    }
}
