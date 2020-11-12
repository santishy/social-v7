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
    $this->browse(function (Browser $browser) use ($user, $comment) {
      $browser->loginAs($user)
        ->visit('/')
        ->waitForText($comment->body, 5)
        ->assertSee($comment->body)
        ->assertSeeIn('@comment-likes-count', 0)
        ->press('@comment-like-btn', 5)
        ->waitForText('Te gusta')
        ->assertSee('Te gusta')
        ->assertSeeIn('@comment-likes-count', 1)
        ->press('@comment-like-btn', 5)
        ->waitForText('Me gusta', 7)
        ->assertSee('Me gusta')
        ->waitForText(0)
        ->pause(1000)
        ->assertSeeIn('@comment-likes-count', 0);
    });
  }
  /** @test */
  public function users_can_see_likes_and_unlikes_in_real_time_in_comments()
  {
    $user = factory(User::class)->create();
    $comment = factory(Comment::class)->create();
    $this->browse(function (Browser $browser1, Browser $browser2) use ($user, $comment) {
      $browser1->visit('/');

      $browser2->loginAs($user)
        ->visit('/')
        ->waitForText($comment->body, 5)
        ->assertSeeIn('@comment-likes-count', 0)
        ->press('@comment-like-btn')
        ->waitForText('Te gusta');

      $browser1->assertSeeIn('@comment-likes-count', 1);

      $browser2->press('@comment-like-btn')
        ->waitForText('Me gusta');

      $browser1->pause(1000)->assertSeeIn('@comment-likes-count', 0);
    });
  }
}
