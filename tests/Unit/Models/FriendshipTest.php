<?php

namespace Tests\Unit\Models;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
//use PHPUnit\Framework\TestCase;
use App\User;
use App\Models\Friendship;

class FriendshipTest extends TestCase
{
    use RefreshDatabase;
    /**
    *@test
    */
    public function a_friendship_request_belongs_to_a_sender(){
      $sender = factory(User::class)->create();
      $friendship = factory(Friendship::class)->create(['sender_id' => $sender->id]);
      $this->assertInstanceOf(User::class,$friendship->sender);
    }
    /**
    *@test
    */
    public function a_friendship_request_belongs_to_a_recipient(){
      $sender = factory(User::class)->create();
      $friendship = factory(Friendship::class)->create(['recipient_id' => $sender->id]);
      $this->assertInstanceOf(User::class,$friendship->recipient);
    }
    /**
     *@test
     */
    public function can_find_friendships_by_sender_and_recipient(){
      $recipient = factory(User::class)->create();
      $sender = factory(User::class)->create();
      Friendship::create([
        'sender_id' => $sender->id,
        'recipient_id' => $recipient->id
      ]);
      factory(Friendship::class,2)->create([
        'recipient_id' => $recipient->id
      ]);
      
      factory(Friendship::class,2)->create([
        'sender_id' => $sender->id
      ]);
      $friendship = Friendship::betweenUsers($sender,$recipient)->first();
      $this->assertEquals($sender->id,$friendship->sender_id);
      $this->assertEquals($recipient->id,$friendship->recipient_id);

      $friendship = Friendship::betweenUsers($recipient,$sender)->first();
      $this->assertEquals($sender->id,$friendship->sender_id);
      $this->assertEquals($recipient->id,$friendship->recipient_id);
    }
}
