<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        return [
          'user_name' => $this->user->name,
          'body' => $this->body,
          'user_avatar' => $this->user->avatar(),
          'ago' => $this->created_at->diffForHumans(),
          'id' => $this->id,
          'is_liked' => $this->isLiked(),
          'likes_count' => $this->likesCount(),
          'user_link' => $this->user->link(),
          'comments' => CommentResource::collection($this->comments),
        ];
    }
}
