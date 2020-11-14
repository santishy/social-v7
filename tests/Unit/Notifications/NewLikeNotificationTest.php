<?php

namespace Tests\Unit\Notifications;

use App\User;
use App\Models\Status;
use Tests\TestCase;
use App\Notifications\NewLikeNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

class NewLikeNotificationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function the_notification_stored_in_the_database()
    {
        $statusOwner = factory(User::class)->create();
        $status = factory(Status::class)->create([
            'user_id' => $statusOwner->id
        ]);
        $likeSender = factory(User::class)->create();
        $status->likes()->firstOrCreate([
            'user_id' => $likeSender->id
        ]);
        $statusOwner->notify(new NewLikeNotification($likeSender, $status));
        $this->assertEquals($status->path(), $statusOwner->notifications()->first()->data['link']);
        $this->assertEquals("Al usuario {$likeSender->name} le gusto tu publicación.", $statusOwner->notifications()->first()->data['message']);
    }
}
