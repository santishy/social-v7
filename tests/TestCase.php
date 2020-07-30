<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function assertClassUsesTrait($trait,$class){
        $this->assertArrayHasKey(
                                  $trait,
                                  class_uses($class),
                                  'Comment class must use HasLikes'
                                );
    }
}
