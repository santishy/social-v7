<?php

namespace Tests\Unit\Models;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use App\Models\Status;
use Tests\TestCase;
use App\User;
use App\Models\Like;
use App\Models\Comment;

class StatusTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_status_belongs_to_a_user(){

      $status = factory(Status::class)->create();
      $this->assertInstanceOf(User::class,$status->user);
    }
    /**
    *@test
    */
    public function a_status_morph_many_likes(){
      $status = factory(Status::class)->create();
      $like = factory(Like::class)->create([
        'likeable_id' => $status->id,
        'likeable_type' => get_class($status),
      ]);
      $this->assertInstanceOf(Like::class,$status->likes()->first());
    }
    /** @test */
    public function a_status_has_many_comments(){
      $status = factory(Status::class)->create();
      $comments = factory(Comment::class)->create(['status_id' => $status->id]);
      $this->assertInstanceOf(Comment::class,$status->comments()->first());
    }
    /** @test */
    public function a_status_can_be_liked_and_unlike(){
      $status = factory(Status::class)->create();
      $this->actingAs(factory(User::class)->create());
      $this->assertInstanceOf(Like::class,$status->like());
      $this->assertEquals(1,$status->likes->count());
      $status->unliked();
      $this->assertEquals(0,$status->fresh()->likes->count());

    }
    /** @test */
    public function a_status_can_be_liked_once(){
      $status = factory(Status::class)->create();
      $this->actingAs(factory(User::class)->create());
      $status->like();
      $this->assertInstanceOf(Like::class,$status->like());
      $this->assertEquals(1,$status->fresh()->likes->count());
      //dd($status->fresh()->likes->count());
    }
    /** @test */
    public function a_status_knows_if_it_been_liked(){
      $user = factory(User::class)->create();
      $status = factory(Status::class)->create();
      $this->actingAs($user);
      $this->assertFalse($status->isLiked());
      $status->like();
      $this->assertTrue($status->isLiked());
    }
    /** @test */
    public function a_status_knows_how_many_likes_it_has(){
      $status = factory(Status::class)->create();
      $this->assertEquals(0,$status->likesCount());
      factory(Like::class,2)->create([
                                      'likeable_id' => $status->id,
                                      'likeable_type' => get_class($status)
                                    ]);
      $this->assertEquals(2,$status->likesCount());
    }

}