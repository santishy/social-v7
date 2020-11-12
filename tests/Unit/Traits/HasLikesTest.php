<?php

namespace Tests\Unit\Traits;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use App\User;
use Tests\TestCase;
//use PHPUnit\Framework\TestCase;

use Illuminate\Database\Schema\Blueprint;
use App\Traits\HasLikes;
use Illuminate\Support\Facades\Event;
use App\Events\ModelLiked;
use App\Events\ModelUnliked;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Schema;

class HasLikesTest extends TestCase
{
  use RefreshDatabase;

  protected function setUp():void{
    parent::setUp();
    Event::fake([ModelLiked::class]);// ESTA FACHADA Y METODO FAKE, SIMULA QUE SE EJECUTA EL EVENTO INCLUSO SE PUEDE INSPECCIONAR SUS DATOS DE DICHO EVENTO
    Schema::create('model_with_likes',function(Blueprint $table){
      $table->id();
    });
  }
  /**
  *@test
  */
  public function a_model_morph_many_likes(){
    $this->withoutExceptionHandling();
    $model = ModelWithLike::create();
    $like = factory(Like::class)->create([
      'likeable_id' => $model->id,
      'likeable_type' => get_class($model),
    ]);
    $this->assertInstanceOf(Like::class,$model->likes()->first());
  }

  /** @test */
  public function a_model_can_be_liked_and_unlike(){
    
    $model = ModelWithLike::create();
    $this->actingAs(factory(User::class)->create());
    $this->assertInstanceOf(Like::class,$model->like());
    $this->assertEquals(1,$model->likes()->count());
    $model->unliked();
    $this->assertEquals(0,$model->likes()->count());
  }

  /** @test */
  public function a_model_can_be_liked_once(){
    $model = ModelWithLike::create();
    $this->actingAs(factory(User::class)->create());
    $model->like();
    $this->assertInstanceOf(Like::class,$model->like());
    $this->assertEquals(1,$model->likes()->count());
    //dd($status->fresh()->likes->count());
  }

  /** @test */
  public function a_model_knows_if_it_been_liked(){
    $user = factory(User::class)->create();
    $model =ModelWithLike::create();
    $this->actingAs($user);
    $this->assertFalse($model->isLiked());
    $model->like();
    $this->assertTrue($model->isLiked());
  }
  /** @test */
  public function a_model_knows_how_many_likes_it_has(){
    $model = ModelWithLike::create();
    $this->assertEquals(0,$model->likesCount());
    factory(Like::class,2)->create([
                                    'likeable_id' => $model->id,
                                    'likeable_type' => get_class($model)
                                  ]);
    $this->assertEquals(2,$model->likesCount());
  }
  /** @test */
  public function an_event_fired_when_a_model_is_liked(){
    //Event::fake([ModelLiked::class]);
    Broadcast::shouldReceive('socket')->andReturn('socket-id');
    $model  = ModelWithLike::create();
    $this->actingAs($likeSender = factory(User::class)->create());
    $model->like();
    
    Event::assertDispatched(ModelLiked::class,function($e) use($likeSender){ 
      $this->assertInstanceOf(ModelWithLike::class,$e->model,'esta no es una isntacia de model');
      $this->assertEventChannelType('public',$e);
      $this->assertEventChannelName($e->model->eventChannelName(),$e);
      $this->assertDontBroadcastToCurrentUser($e);
      $this->assertTrue($e->likeSender->is($likeSender));
      return true;
    });
  }
   /** @test */
   public function an_event_fired_when_a_model_is_unliked(){
    Event::fake([ModelUnliked::class]);
    Broadcast::shouldReceive('socket')->andReturn('socket-id');
    $model  = ModelWithLike::create();
    $this->actingAs(factory(User::class)->create());
    $model->likes()->firstOrCreate([
      'user_id' => auth()->id()
    ]);
    $model->unliked();
    Event::assertDispatched(ModelUnliked::class,function($e){ 
      $this->assertInstanceOf(ModelWithLike::class,$e->model,'esta no es una isntacia de model');
      $this->assertEventChannelType('public',$e);
      $this->assertEventChannelName($e->model->eventChannelName(),$e);
      $this->assertDontBroadcastToCurrentUser($e);
      return true;
    });
  }
  /** @test */
  public function can_get_the_event_channel_name(){
    $model  = ModelWithLike::create();
    $this->assertEquals(
      'modelwithlikes.1.likes',
      $model->eventChannelName()
    );
  }
}

class ModelWithLike extends Model
{
  protected $fillable =['id'];
  public $timestamps=false;
  use HasLikes;
}
