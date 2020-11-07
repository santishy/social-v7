<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

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
    public function assertEventChannelName($channelName,$event){
        $this->assertEquals($channelName,$event->broadcastOn()->name); //aqui se llama a la proiedad name .. de la instancia channel donde existe una propiedad publica llamada name y es la misma cadena que pasamos por el constructor
    }
    public function assertEventChannelType($channelType,$event){
        $types = [
            'public' => \Illuminate\Broadcasting\Channel::class,
            'private' => \Illuminate\Broadcasting\PrivateChannel::class,
            'presence' => Illuminate\Broadcasting\PresenceChannel::class
        ];
        $this->assertEquals($types[$channelType],get_class($event->broadcastOn())); //esta asercion es mas precisa ya que obtengo la clase de la instancia que devuelve broadcastOn ... get_class(broadcastonOn) y lo comparo con /Illuminate/.../Channel::class que es la misca cadena obtenida por get_class(...)
    }
    public function assertDontBroadcastToCurrentUser($event){
        $this->assertInstanceOf(ShouldBroadcast::class,$event); //para que funcione el metodo broadcastOn
        $this->assertEquals('socket-id',$event->socket,'The event ' . get_class($event) . 'must call the method "dontBroadcastToCurrentUser" in the constructor');
    }
}
