<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use App\Models\Status;
use Tests\TestCase;
use App\User;
use App\Traits\HasLikes;
use App\Models\Like;
use App\Models\Comment;

class CommentTest extends TestCase
{
  use RefreshDatabase;
  /**
   *@test
   */
  public function a_comment_belongs_to_user()
  {
    $status = factory(Status::class)->create();
    $comment = factory(Comment::class)->create(['status_id' => $status->id]);
    $this->assertInstanceOf(User::class, $comment->user);
  }

  /**
   *@test
   */

  public function a_comment_model_must_use_the_trait_has_likes()
  {
    $this->assertClassUsesTrait(HasLikes::class, Comment::class);
  }

  /** @test */

  public function a_comment_must_have_a_path()
  {
    $status = factory(Status::class)->create();
    $comment = factory(Comment::class)->create([
      'status_id' => $status->id
    ]);
    $this->assertEquals(route('statuses.show', $status->id)."#comment-{$comment->id}",$comment->path());
  }

  /** @test */
  public function a_comment_belongs_to_status(){
    $comment = factory(Comment::class)->create();
    $this->assertInstanceOf(Status::class,$comment->status);
  }

  
}
