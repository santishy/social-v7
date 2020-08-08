<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class CanSeeProfilesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function can_see_profiles_test()
    {
      //  $this->withoutExceptionHandling();
        $user = factory(User::class)->create(['name' => 'pepe']);
        $response = $this->get('@pepe');
        $response->assertSee('pepe');
    }
}
