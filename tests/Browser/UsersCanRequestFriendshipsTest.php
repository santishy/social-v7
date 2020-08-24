<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;

class UsersCanRequestFriendshipsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
    *@test
    */
    public function users_can_request_friendship(){
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();
        $this->browse(function (Browser $browser) use ($sender,$recipient) {
          $browser->loginAs($sender)
                  ->visit(route('users.show',$recipient))
                  ->press('@request-friendship')
                  ->waitForText('Cancelar solicitud')
                  ->assertSee('Cancelar solicitud')
                  ->visit(route('users.show',$recipient))
                  ->assertSee('Cancelar solicitud')
                  ->press('@request-friendship')
                  ->waitForText('Solicitar amistad')
                  ->assertSee('Solicitar amistad');
        });
    }
}
