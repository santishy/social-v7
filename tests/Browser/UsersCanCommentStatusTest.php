<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Status;
use App\Models\Comment;
use App\User;

class UsersCanCommentStatusTest extends DuskTestCase
{
  use DatabaseMigrations;
  /**
  *@test
  */
  public function authenticated_users_can_comment_status()
  {
    $status = factory(Status::class)->create();
    $user = factory(User::class)->create();
    $this->browse(function (Browser $browser) use ($user,$status) {
        $browser->loginAs($user)
                ->visit('/')
                ->waitForText($status->body)
                ->assertSee($status->body)
                ->type('comment','Mi primer comentario')
                ->press('@comment-btn')
                ->waitForText('Mi primer comentario');
    });
  }
  /**
  *@test
  */
  public function users_can_see_comments(){
    $status = factory(Status::class)->create();
    $comments = factory(Comment::class,2)->create(['status_id' => $status->id]);
    $this->browse(function (Browser $browser) use ($status,$comments) {
      $browser->visit('/')
              ->waitForText($status->body);
      foreach($comments as $comment){
        $browser->assertSee($comment->body)
                ->assertSee($comment->user->name);
      }
    });
  }
}
