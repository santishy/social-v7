<?php

namespace Tests\Unit\Notifications;

use App\Notifications\NewCommentNotification;
use App\Notifications\NewLikeNotification;
use Tests\TestCase;
use App\User;
use App\Models\Comment;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewCommentNotificationTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */

    public function the_notification_stored_in_the_database(){
        $status = factory(Status::class)->create();
        $comment = factory(Comment::class)->create(['status_id' => $status->id]);
        $statusOwner =  $status->user;
        $notification = $statusOwner->notify(new NewCommentNotification($comment));
        $notificationData = $statusOwner->notifications->first()->data;
        $this->assertCount(1,$statusOwner->notifications);
        $this->assertEquals($comment->path(),$notificationData['link']);
        $this->assertEquals("{$comment->user->name} comento tu publicación.",$notificationData['message']);

    }
}
