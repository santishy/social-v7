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
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class SendNewLikeNotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function a_notification_sent_when_an_user_receives_an_new_like()
    {
        //[model , 'mensaje la envio {user}' ,'link' ]
        $statusOwner = factory(User::class)->create();
        $status = factory(Status::class)->create([
            'user_id' => $statusOwner->id
        ]);
        $likeSender = factory(User::class)->create();
        $status->likes()->firstOrCreate([
            'user_id' => $likeSender->id
        ]);
        FacadesNotification::fake([NewLikeNotification::class]);
        ModelLiked::dispatch($status,$likeSender);
        FacadesNotification::assertSentTo($statusOwner, NewLikeNotification::class, function ($notification,$channels) use($likeSender,$status) {
            $this->assertContains('database',$channels);
            $this->assertContains('broadcast',$channels);
            $this->assertInstanceOf(BroadcastMessage::class,$notification->toBroadcast($status->user));
            $this->assertTrue($notification->likeSender->is($likeSender));
            $this->assertTrue($notification->model->is($status));
            return true;
        });
    }
}
