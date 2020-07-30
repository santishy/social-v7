<?php

namespace Tests\Unit\Traits;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use App\User;
use Tests\TestCase;
use App\Traits\HasLikes;

class HasLikesTest extends TestCase
{
  use RefreshDatabase;
  /**
  *@test
  */
  public function a_model_morph_many_likes(){
    $this->withoutExceptionHandling();
    $model = new ModelWithLikes(['id' => 1]);
    $like = factory(Like::class)->create([
      'likeable_id' => $model->id,
      'likeable_type' => get_class($model),
    ]);
    $this->assertInstanceOf(Like::class,$model->likes()->first());
  }

  /** @test */
  public function a_model_can_be_liked_and_unlike(){
    $model = new ModelWithLikes(['id' => 1]);
    $this->actingAs(factory(User::class)->create());
    $this->assertInstanceOf(Like::class,$model->like());
    $this->assertEquals(1,$model->likes()->count());
    $model->unliked();
    $this->assertEquals(0,$model->likes()->count());
  }

  /** @test */
  public function a_model_can_be_liked_once(){
    $model = new ModelWithLikes(['id' => 1]);
    $this->actingAs(factory(User::class)->create());
    $model->like();
    $this->assertInstanceOf(Like::class,$model->like());
    $this->assertEquals(1,$model->likes()->count());
    //dd($status->fresh()->likes->count());
  }

  /** @test */
  public function a_model_knows_if_it_been_liked(){
    $user = factory(User::class)->create();
    $model = new ModelWithLikes(['id' => 1]);
    $this->actingAs($user);
    $this->assertFalse($model->isLiked());
    $model->like();
    $this->assertTrue($model->isLiked());
  }
  /** @test */
  public function a_model_knows_how_many_likes_it_has(){
    $model = new ModelWithLikes(['id' => 1]);
    $this->assertEquals(0,$model->likesCount());
    factory(Like::class,2)->create([
                                    'likeable_id' => $model->id,
                                    'likeable_type' => get_class($model)
                                  ]);
    $this->assertEquals(2,$model->likesCount());
  }
}

class ModelWithLikes extends Model
{
  protected $fillable =['id'];
  use HasLikes;
}
