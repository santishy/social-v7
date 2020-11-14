<?php

namespace Tests\Feature;

use App\Notifications\NewLikeNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CanGetNotificationTest extends TestCase
{
    /** @test */
    public function authenticated_users_can_get_their_notifications(){
        $statusOwner = factory(User::class)->create();
        $status = factory(Status::class)->create([
            'user_id' => $statusOwner->id
        ]);
        $likeSender = factory(User::class)->create();
        $status->likes()->create([
            'user_id' => $likeSender->id
        ]);
        $statusOwner->notify(new NewLikeNotification($likeSender,$status));
        $this->assertEquals(route())
    }
}
