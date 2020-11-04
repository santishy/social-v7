<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Friendship extends Model
{
    protected $guarded = [];

    public function sender(){
      return $this->belongsTo(User::class);
    }

    public function recipient(){
      return $this->belongsTo(User::class); //no se pasa la foranea por que se calcula con el nombre del metodo recipient_id
    }
    /**
     * Encuentra quien le envio una solicitud o a quien se la envio 
     */
    public function scopeBetweenUsers($query,$sender,$recipient){
      return $query->where([
        [ 'sender_id',$sender->id],
        ['recipient_id' , $recipient->id],
      ])
      ->orWhere([
        ['sender_id', $recipient->id],
        ['recipient_id', $sender->id]
      ]);
    }
}
