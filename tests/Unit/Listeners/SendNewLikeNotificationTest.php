<?php

namespace Tests\Unit\Listeners;

use App\Events\ModelLiked;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\Status;
use App\Notifications\NewLikeNotification;
use App\User;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class SendNewLikeNotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function a_notification_sent_when_an_user_receives_an_new_like()
    {
        
        $statusOwner = factory(User::class)->create();
        $status = factory(Status::class)->create([
            'user_id' => $statusOwner->id
        ]);
        FacadesNotification::fake([NewLikeNotification::class]);
        ModelLiked::dispatch($status);
        FacadesNotification::assertSentTo($statusOwner,NewLikeNotification::class);

    }
}
