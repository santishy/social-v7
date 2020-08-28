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
}
