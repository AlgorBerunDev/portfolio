<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'id' => $this->id,
                'fcmToken' => $this->fcmToken,
                'access_token' => $this->access_token,
                'refresh_token' => $this->refresh_token,
            ],
            'message' => "Session data"
        ];
    }
}
