<?php

namespace Tests\Unit;

use App\Models\Friendship;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Models\Status;

class UserTest extends TestCase
{

    use RefreshDatabase;

    /** @test **/
    public function route_key_is_set_to_name(){
      //$user = new User;
      $user = factory(User::class)->make(); // esto crea solo una instancia
      $this->assertEquals(
        'name',
        $user->getRouteKeyName(),
        'The route key name must be name'
      );
    }

    /** @test */
    public function user_has_a_link_to_their_profile(){
      $user = factory(User::class)->make();
      $this->assertEquals(
        route('users.show',$user),
        $user->link()
      );
    }

    /** @test */
    public function user_has_a_avatar(){
      $user = factory(User::class)->make();
      $this->assertEquals(
        'https://aprendible.com/images/default-avatar.jpg',
        $user->avatar()
      );
      $this->assertEquals(
        'https://aprendible.com/images/default-avatar.jpg',
        $user->avatar
      );
    }

    /**
    *@test
    */
    public function a_user_has_many_statuses(){
      $user = factory(User::class)->create();
      factory(Status::class,2)->create(['user_id' => $user->id]);
      $this->assertInstanceOf(
        Status::class,
        $user->statuses()->first()
      );
    }

    /** @test */
    public function a_user_see_friend_requests(){
      $sender = factory(User::class)->create();
      $recipient = factory(User::class)->create();
      $friendship = $sender->sendFriendRequestTo($recipient);
      $this->assertInstanceOf(Friendship::class,$sender->sendFriendRequestTo($recipient));

      $this->assertTrue($friendship->sender->is($sender));
      $this->assertTrue($friendship->recipient->is($recipient));
    }

    /** @test */
    public function a_user_can_accept_friend_request(){
      $sender = factory(User::class)->create();
      $recipient = factory(User::class)->create();
      $sender->sendFriendRequestTo($recipient); //se crea la amistad
      
    }
}
