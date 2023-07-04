<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'title'             => $this->title,
            'text'              => $this->text,
            'user'              => [
                                        'id'        => $this->user_id,
                                        'name'      => User::findOrFail($this->user_id)->name,
                                        'last_name' => User::findOrFail($this->user_id)->last_name,
                                    ],
            'users'             => UsersResource::collection($this->users),
            'created_at'        => $this->created_at->format('d.m.Y'),
        ];
    }
}
