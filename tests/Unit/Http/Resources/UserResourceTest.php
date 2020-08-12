<?php

namespace Tests\Unit\Http\Resources;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Http\Resources\UserResource;

class UserResourceTest extends TestCase
{
    use RefreshDatabase;
    /**
    *@test
    */
    public function a_comment_resources_have_must_the_necessary_fields(){
      $this->withoutExceptionHandling();
      $user = factory(User::class)->create();
      $userResource = UserResource::make($user)->resolve();
      $this->assertEquals(
        $user->name,
        $userResource['name']
      );
      $this->assertEquals(
        $user->avatar(),
        $userResource['avatar']
      );
      $this->assertEquals(
        $user->link(),
        $userResource['link']
      );
      $this->assertEquals(
        $user->id,
        $userResource['id']
      );

    }
}
