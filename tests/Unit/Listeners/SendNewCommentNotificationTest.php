<?php

namespace Tests\Unit\Listeners;

use App\Events\CommentCreated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Notifications\NewCommentNotification;
use App\Models\Status;
use App\Models\Comment;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendNewCommentNotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function a_notification__is_send_when_a_status_receives_a_new_comment()
    {
        Notification::fake();
        $status = factory(Status::class)->create();
        $comment = factory(Comment::class)->create([
            'status_id' => $status->id
        ]);
        CommentCreated::dispatch($comment);
        
        Notification::assertSentTo($status->user,NewCommentNotification::class,function($notification,$channels) use($comment){
            $this->assertTrue($notification->comment->is($comment));
            return true;
        });
    }
}
