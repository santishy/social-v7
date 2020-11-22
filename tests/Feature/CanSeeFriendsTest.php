<?php

namespace Tests\Feature;

use App\Models\Friendship;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\User;
use Tests\TestCase;

class CanSeeFriendsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_see_list_of_friends(){
       
        $recipient = factory(User::class)->create();
        $sender = factory(User::class)->create();
       // $sender->sendFriendRequestTo($recipient); se usa un factory para aceptar la amistad directamente
        factory(Friendship::class)->create([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
            'status' => 'accepted'
        ]);
        $this->actingAs($recipient)->get(route('friends.index'))->assertSee($sender->name);
        $this->actingAs($sender)->get(route('friends.index'))->assertSee($recipient->name);
        $this->assertEquals($recipient->name,$sender->friends()->first()->name);
        $this->assertEquals($sender->name,$recipient->friends()->first()->name);
    }

    /** @test */
    public function a_guests_cannot_see_list_of_friends(){
        $this->get(route('friends.index'))->assertRedirect('login');
    }
}
