<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CanRequestFriendshipsTest extends TestCase
{
    /**
    *@test
    */
    public function can_send_friendship_request(){
      $sender = factory(User::class)->create();
      $recipient = factory(User::class)->create();
    }
}
