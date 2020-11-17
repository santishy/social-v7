<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\DatabaseNotification;
use Laravel\Dusk\Browser;
use App\User;
use App\Models\Status;
use Tests\DuskTestCase;

class UsersCanManageTheirNotificationsTest extends DuskTestCase
{

    use DatabaseMigrations;

    /** @test */
    public function users_can_see_their_notifications_in_the_navbar(){
        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();
        $notification = factory(DatabaseNotification::class)->create([
            'notifiable_id' => $user->id,
            'data' => [
                'link' => route('statuses.show',$status),
                'message' => 'Has recibido una notificación'
            ]
        ]);
        $this->browse(function (Browser $browser) use ($user,$notification,$status) {
            $browser->loginAs($user)
                    ->visit('/')
                    ->click('@notifications')
                    ->assertSee('Has recibido una notificación')
                    ->click("@$notification->id")
                    ->assertUrlIs($status->path())
                    ->click('@notifications')
                    ->press('@mark-as-read-'.$notification->id)
                    ->waitForText("@mark-as-unread-$notification->id")
                    ->assertMissingSee('@mark-as-read-'.$notification->id);
        });
    }

    
}
