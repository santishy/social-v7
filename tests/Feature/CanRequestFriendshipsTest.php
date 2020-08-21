<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Models\Friendship;

class CanRequestFriendshipsTest extends TestCase
{
    use RefreshDatabase;

    /**
    *@test
    */
    public function can_send_friendship_request(){
      $this->withoutExceptionHandling();
      $sender = factory(User::class)->create();
      $recipient = factory(User::class)->create();
      $this->actingAs($sender)->postJson(route('friendships.store',$recipient));
      $this->assertDatabaseHas('friendships',[
        'recipient_id' => $recipient->id,
        'sender_id' => $sender->id,
        'status' => 'pending',
      ]);
    }

    /**
    *@test
    */
    public function can_delete_friendship_request(){
      $this->withoutExceptionHandling();
      $sender = factory(User::class)->create();
      $recipient = factory(User::class)->create();
      Friendship::create([
        'sender_id' => $sender->id,
        'recipient_id' => $recipient->id
      ]);
      $this->actingAs($sender)->deleteJson(route('friendships.destroy',$recipient));
      $this->assertDatabaseMissing('friendships',[
        'recipient_id' => $recipient->id,
        'sender_id' => $sender->id,
      ]);
    }

    /**
    *@test
    */
    public function can_accept_friendship_request(){
      $this->withoutExceptionHandling();
      $sender = factory(User::class)->create();
      $recipient = factory(User::class)->create();
      Friendship::create([
        'sender_id' => $sender->id,
        'recipient_id' => $recipient->id,
      ]);

      $response = $this->actingAs($recipient)
                       ->postJson(route('accept-friendships.store',$sender)); //usamos otro controlador aparentemente por que es otra ruta de soliciutd de amistad y cambia el nombre del controlador y usamos post por q se crea la nueva a mistad ojo pero se modifica la tabla friendships
      $this->assertDatabaseHas('friendships',[
        'recipient_id' => $recipient->id,
        'sender_id' => $sender->id,
        'status' => 'accepted',
      ]);
    }

    /**
    *@test
    */
    public function can_deny_friendship_request(){
      $this->withoutExceptionHandling();
      $sender = factory(User::class)->create();
      $recipient = factory(User::class)->create();
      Friendship::create([
        'sender_id' => $sender->id,
        'recipient_id' => $recipient->id,
      ]);

      $this->actingAs($recipient)->deleteJson(route('accept-friendships.destroy',$sender)); //usamos otro controlador aparentemente por que es otra ruta de soliciutd de amistad y cambia el nombre del controlador y usamos post por q se crea la nueva a mistad ojo pero se modifica la tabla friendships
      $this->assertDatabaseHas('friendships',[
        'recipient_id' => $recipient->id,
        'sender_id' => $sender->id,
        'status' => 'denied',
      ]);
    }
}
