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
  public function guests_users_cannot_accept_friendship_request()
  {

    $sender = factory(User::class)->create();
    $response = $this->postJson(route('accept-friendships.store', $sender)); //usamos otro controlador aparentemente por que es otra ruta de soliciutd de amistad y cambia el nombre del controlador y usamos post por q se crea la nueva a mistad ojo pero se modifica la tabla friendships
    $response->assertStatus(401);
    $response = $this->get(route('accept-friendships.index'));
    $response->assertRedirect('login');
  }
  /**
   *@test
   */
  public function guests_users_cannot_create_friendship_request()
  {

    $recipient = factory(User::class)->create();
    $response = $this->postJson(route('friendships.store', $recipient));
    $response->assertStatus(401);
  }

  /**
   *@test
   */
  public function senders_can_send_friendship_request()
  {
    $this->withoutExceptionHandling();
    $sender = factory(User::class)->create();
    $recipient = factory(User::class)->create();
    $response = $this->actingAs($sender)->postJson(route('friendships.store', $recipient));
    $response->assertJson([
      'friendship_status' => 'pending'
    ]);
    $this->assertDatabaseHas('friendships', [
      'recipient_id' => $recipient->id,
      'sender_id' => $sender->id,
      'status' => 'pending',
    ]);
    $this->actingAs($sender)->postJson(route('friendships.store', $recipient));
    $this->assertCount(1, Friendship::all());
  }
  /**
  *@test
  */
  public function a_user_cannot_send_request_to_itself(){
    $sender = factory(User::class)->create();
    $response = $this->actingAs($sender)->postJson(route('friendships.store', $sender));
    $this->assertDatabaseMissing('friendships', [
      'recipient_id' => $sender->id,
      'sender_id' => $sender->id,
      'status' => 'pending',
    ]);
  }
  /**
   *@test
   */
  public function guests_users_cannot_delete_friendship_request()
  {

    $recipient = factory(User::class)->create();
    $response = $this->deleteJson(route('friendships.destroy', $recipient));
    $response->assertStatus(401);
  }

  /**
   *@test
   */
  public function senders_can_delete_send_friendship_request()
  {
    $this->withoutExceptionHandling();
    $sender = factory(User::class)->create();
    $recipient = factory(User::class)->create();
    Friendship::create([
      'sender_id' => $sender->id,
      'recipient_id' => $recipient->id
    ]);
    $response = $this->actingAs($sender)->deleteJson(route('friendships.destroy', $recipient));
    $response->assertJson([
      'friendship_status' => 'deleted'
    ]);
    $this->assertDatabaseMissing('friendships', [
      'recipient_id' => $recipient->id,
      'sender_id' => $sender->id,
    ]);
  }
  /**
   * @test
   */
  public function recipients_can_delete_denied_friendship_request(){
    $this->withoutExceptionHandling();
    $sender = factory(User::class)->create();
    $recipient = factory(User::class)->create();
    Friendship::create([
      'sender_id' => $sender->id,
      'recipient_id' => $recipient->id,
      'status' => 'denied'
    ]);
    $response = $this->actingAs($recipient)->deleteJson(route('friendships.destroy', $sender));
    $response->assertJson([
      'friendship_status' => 'deleted'
    ]);
    $this->assertDatabaseMissing('friendships', [
      'recipient_id' => $recipient->id,
      'sender_id' => $sender->id,
      'status' => 'denied'
    ]);
  }
  /**
   *@test
   */
  public function senders_cannot_delete_denied_friendship_request()
  {
    $this->withoutExceptionHandling();
    $sender = factory(User::class)->create();
    $recipient = factory(User::class)->create();
    Friendship::create([
      'sender_id' => $sender->id,
      'recipient_id' => $recipient->id,
      'status' => 'denied'
    ]);
    $response = $this->actingAs($sender)->deleteJson(route('friendships.destroy', $recipient));
    $response->assertJson([
      'friendship_status' => 'denied'
    ]);
    $this->assertDatabaseHas('friendships', [
      'recipient_id' => $recipient->id,
      'sender_id' => $sender->id,
      'status' => 'denied'
    ]);
  }

  /**
   *@test
   */
  public function can_accept_friendship_request()
  {
    $this->withoutExceptionHandling();
    $sender = factory(User::class)->create();
    $recipient = factory(User::class)->create();
    Friendship::create([
      'sender_id' => $sender->id,
      'recipient_id' => $recipient->id,
    ]);

    $response = $this->actingAs($recipient)
      ->postJson(route('accept-friendships.store', $sender)); //usamos otro controlador aparentemente por que es otra ruta de soliciutd de amistad y cambia el nombre del controlador y usamos post por q se crea la nueva a mistad ojo pero se modifica la tabla friendships
    $response->assertJson([
      'friendship_status' => 'accepted'
    ]);
    $this->assertDatabaseHas('friendships', [
      'recipient_id' => $recipient->id,
      'sender_id' => $sender->id,
      'status' => 'accepted',
    ]);
  }

  /**
   *@test
   */
  public function guests_users_cannot_deny_friendship_request()
  {
    $sender = factory(User::class)->create();
    $response = $this->deleteJson(route('accept-friendships.destroy', $sender)); //usamos otro controlador aparentemente por que es otra ruta de soliciutd de amistad y cambia el nombre del controlador y usamos post por q se crea la nueva a mistad ojo pero se modifica la tabla friendships
    $response->assertStatus(401);
  }
  /**
   *@test
   */
  public function can_deny_friendship_request()
  {
    $this->withoutExceptionHandling();
    $sender = factory(User::class)->create();
    $recipient = factory(User::class)->create();
    Friendship::create([
      'sender_id' => $sender->id,
      'recipient_id' => $recipient->id,
    ]);

    $response = $this->actingAs($recipient)->deleteJson(route('accept-friendships.destroy', $sender)); //usamos otro controlador aparentemente por que es otra ruta de soliciutd de amistad y cambia el nombre del controlador y usamos post por q se crea la nueva a mistad ojo pero se modifica la tabla friendships
    $response->assertJson([
      'friendship_status' => 'denied'
    ]);
    $this->assertDatabaseHas('friendships', [
      'recipient_id' => $recipient->id,
      'sender_id' => $sender->id,
      'status' => 'denied',
    ]);
  }
  /**
   *@test
   */
  public function recipients_can_delete_receiveds_friendship_request()
  {
    $this->withoutExceptionHandling();
    $sender = factory(User::class)->create();
    $recipient = factory(User::class)->create();
    Friendship::create([
      'sender_id' => $sender->id,
      'recipient_id' => $recipient->id
    ]);
    $response = $this->actingAs($recipient)->deleteJson(route('friendships.destroy', $sender));
    $response->assertJson([
      'friendship_status' => 'deleted'
    ]);
    $this->assertDatabaseMissing('friendships', [
      'recipient_id' => $recipient->id,
      'sender_id' => $sender->id,
    ]);
  }
}
