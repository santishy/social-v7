<?php

namespace Tests\Feature;

use App\Models\Friendship;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\User;
use Tests\TestCase;

class CanGetFriendshipTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_get_friendships(){
        $this->getJson(route('friendships.show','jorge'))
            ->assertStatus(401);
    }

    /** @test */
    public function can_get_friendship(){
        $sender =  factory(User::class)->create();
        $recipient = factory(User::class)->create();
        $friendship = factory(Friendship::class)->create([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id
        ]);
        $response = $this->actingAs($sender)->get(route('friendships.show',$recipient));
        $response->assertJsonFragment([
            'friendship_status' => $friendship->fresh()->status,
        ]);
   }
}
