<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Status;
use App\Models\Comment;
use App\Models\Friendship;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['avatar'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'name';
    }
    public function link(){
      return route('users.show',$this);
    }
    public function avatar(){
      return 'https://aprendible.com/images/default-avatar.jpg';
    }
    public function getAvatarAttribute(){
      return $this->avatar();
    }
    public function statuses(){
      return $this->hasMany(Status::class);
    }
    public function comments(){
      return $this->hasMany(Comment::class);
    }
    public function sendFriendRequestTo($recipient){
      return  Friendship::firstOrCreate([
        'sender_id' => $this->id,
        'recipient_id' => $recipient->id,
      ]);
    }
}
