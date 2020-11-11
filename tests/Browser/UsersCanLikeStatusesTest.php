<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;
use App\Models\Status;

class UsersCanLikeStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;
    /** @test */
    public function guests_users_cannot_like_and_unlike_statuses()
    {

        $status = factory(Status::class)->create();
        $this->browse(function (Browser $browser) use ($status) {
            $browser->visit('/')
                ->waitForText($status->body)
                ->press('@like-btn')
                ->assertPathIs('/login');
        });
    }
    /**
     * @test
     */
    public function users_can_like_and_unlike_statuses()
    {
        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->browse(function (Browser $browser) use ($user, $status) {
            $browser->loginAs($user)
                ->visit('/')
                ->waitForText($status->body)
                ->assertSee($status->body)
                ->assertSeeIn('@likes-count', 0)
                ->press('@like-btn')
                ->waitForText('Te gusta')
                ->assertSee('Te gusta')
                ->assertSeeIn('@likes-count', 1)
                ->press('@like-btn')
                ->waitForText('Me gusta')
                ->assertSee('Me gusta')
                ->assertSeeIn('@likes-count', 0);
        });
    }
    /**
     * @test
     */
    public function users_can_see_likes_and_unlikes_in_real_time()
    {
        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->browse(function (Browser $browser1, Browser $browser2) use ($user, $status) {
            $browser1->visit('/');
            $browser2->loginAs($user)
                ->visit('/')
                ->waitForText($status->body)
                ->assertSee($status->body)
                ->assertSeeIn('@likes-count', 0)
                ->press('@like-btn')
                ->waitForText('Te gusta');

            $browser1->assertSeeIn('@likes-count', 1);

            $browser2->press('@like-btn')
                ->waitForText('Me gusta');
            $browser1->assertSeeIn('@likes-count',0);
        });
    }
     
}
