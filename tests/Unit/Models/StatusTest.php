<?php

namespace Tests\Unit\Models;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use App\Models\Status;
use Tests\TestCase;
use App\User;

class StatusTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_status_belongs_to_a_user(){

      $status = factory(Status::class)->create();
      $this->assertInstanceOf(User::class,$status->user);
    }
}
