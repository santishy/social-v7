<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;
use App\Models\Friendship;

class UsersCanRequestFriendshipsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
    *@test
    */
    public function senders_can_create_and_delete_friendship_request(){
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();
        $this->browse(function (Browser $browser) use ($sender,$recipient) {
          $browser->loginAs($sender)
                  ->visit(route('users.show',$recipient))
                  ->press('@request-friendship')
                  ->waitForText('Cancelar solicitud')
                  ->assertSee('Cancelar solicitud')
                  ->visit(route('users.show',$recipient))
                  ->waitForText('Cancelar solicitud')
                  ->assertSee('Cancelar solicitud')
                  ->press('@request-friendship')
                  ->waitForText('Solicitar amistad')
                  ->assertSee('Solicitar amistad');
        });
    }
    /**
    *@test
    */
    public function recipients_can_accept_and_deny_friendship_request(){
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();
        Friendship::create([
          'sender_id' => $sender->id,
          'recipient_id' => $recipient->id,
        ]);
        $this->browse(function (Browser $browser) use ($sender,$recipient) {
          $browser->loginAs($recipient)
                  ->visit(route('accept-friendships.index'))
                  ->waitForText($sender->name)
                  ->assertSee($sender->name)
                  ->press('@accept-friendship')
                  ->waitForText('son amigos')
                  ->assertSee('son amigos')
                  ->visit(route('accept-friendships.index'))
                  ->assertSee('son amigos');
        });
    }
}
