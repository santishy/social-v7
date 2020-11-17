<?php

namespace Tests\Feature;

use App\Notifications\NewLikeNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\DatabaseNotification;
use App\User;
use Tests\TestCase;

class CanManageNotificationTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function guests_users_cannot_access_notifications()
    {
        $response = $this->getJson(route('notifications.index'));
        $response->assertStatus(401);
    }
    /** @test */
    public function authenticated_users_can_get_their_notifications()
    {

        $user = factory(User::class)->create();
        $notification = factory(DatabaseNotification::class)->create(['notifiable_id' => $user->id]);
        $response = $this->actingAs($user)->getJson(route('notifications.index'));
        $response->assertJson([
            [
                'data' => [
                    'link' => $notification->data['link'],
                    'message' => $notification->data['message']
                ]
            ]
        ]);
    }

    /** @test */
    public function guests_users_cannot_mark_notifications()
    {
        $notification = factory(DatabaseNotification::class)->create();
        $this->postJson(route('read-notifications.store',$notification))->assertStatus(401);
        $this->deleteJson(route('read-notifications.destroy',$notification))->assertStatus(401);
    }

    /** @test */
    public function authenticated_users_can_mark_notifications_as_read()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $notification = factory(DatabaseNotification::class)->create(['notifiable_id' => $user->id]);
        $response = $this->actingAs($user)->postJson(route('read-notifications.store', $notification));
        $this->assertNotNull($notification->fresh()->read_at);
        $response->assertJson(
            $notification->fresh()->toArray()
        );
    }

    /** @test */
    public function authenticated_users_can_mark_notifications_as_unread()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $notification = factory(DatabaseNotification::class)
            ->create([
                'notifiable_id' => $user->id,
                'read_at' => now()
        ]);
        $response = $this->actingAs($user)->deleteJson(route('read-notifications.destroy', $notification));
        $this->assertNull($notification->fresh()->read_at);
        $response->assertJson(
            $notification->fresh()->toArray()
        );
    }
}
