<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = 'result';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'login'             => $this->login,
            'name'              => $this->name,
            'last_name'         => $this->last_name,
            'birthday'          => $this->birthday,
            'events'            => EventResource::collection($this->events),
            'created_at'        => $this->created_at->format('d.m.Y'),
        ];
    }
}
