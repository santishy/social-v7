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

    /** @test */
    public function a_status_has_many_comments(){
      $status = factory(Status::class)->create();
      $comments = factory(Comment::class)->create(['status_id' => $status->id]);
      $this->assertInstanceOf(Comment::class,$status->comments()->first());
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
