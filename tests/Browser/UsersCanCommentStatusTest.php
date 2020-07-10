<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Status;
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
}
