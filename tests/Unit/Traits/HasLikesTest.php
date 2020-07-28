<?php

namespace Tests\Unit\Traits;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use Tests\TestCase;
use App\Traits\HasLikes;

class HasLikesTest extends TestCase
{
  use RefreshDatabase;
  /**
  *@test
  */
  public function a_model_morph_many_likes(){
    $this->withoutExceptionHandling(['id' => 1]);
    $model = new ModelWithLikes;
    $like = factory(Like::class)->create([
      'likeable_id' => $model->id,
      'likeable_type' => get_class($model),
    ]);
    $this->assertInstanceOf(Like::class,$model->likes()->first());
  }
}

class ModelWithLikes extends Model
{
  protected $fillable =['id'];
  use HasLikes;
}
