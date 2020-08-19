<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;
use App\Models\Status;

class UsersCanSeeProfilesTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
    *@test
    */
    public function users_can_see_profiles(){
      $user = factory(User::class)->create();
      $statuses = factory(Status::class,2)->create(['user_id' => $user->id]);
      $otherStatus = factory(Status::class)->create();
      $this->browse(function (Browser $browser) use ($user,$statuses,$otherStatus) {
            $browser->loginAs($user)
                 ->visit("/@$user->name")
                 ->waitForText($statuses->first()->body)
                 ->assertSee($statuses->first()->body)
                 ->assertSee($statuses->last()->body)
                 ->assertDontSee($otherStatus->body);
      });
    }
}
