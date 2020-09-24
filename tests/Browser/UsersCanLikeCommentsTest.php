<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use App\Models\Comment;
use App\User;
use Tests\DuskTestCase;

class UsersCanLikeCommentsTest extends DuskTestCase
{
  use DatabaseMigrations;
  /**
   * @test
   */
  public function users_can_like_and_unlike_comments()
  {
      $user = factory(User::class)->create();
      $comment = factory(Comment::class)->create();
      $this->browse(function (Browser $browser) use ($user,$comment) {
          $browser->loginAs($user)
                  ->visit('/')
                  ->waitForText($comment->body,5)
                  ->assertSee($comment->body)
                  ->assertSeeIn('@comment-likes-count',0)
                  ->press('@comment-like-btn',5)
                  ->waitForText('Te gusta')
                  ->assertSee('Te gusta')
                  ->assertSeeIn('@comment-likes-count',1)
                  ->press('@comment-like-btn',5)
                  ->waitForText('Me gusta',7)
                  ->assertSee('Me gusta')
                  ->waitForText(0,7)
                  ->assertSeeIn('@comment-likes-count',0);
      });
  }
}
