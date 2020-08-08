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

    /**
    *@test
    */

    public function a_status_model_must_use_the_trait_has_likes(){
      $this->assertClassUsesTrait(HasLikes::class,Comment::class);
    }
    

}
