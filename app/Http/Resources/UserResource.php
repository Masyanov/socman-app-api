<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'second_name'=> $this->second_name,
            'last_name'  => $this->last_name,
            'email'      => $this->email,
            'role'       => $this->role,
            'team_code'  => $this->team_code,
            'active'     => $this->active,
            'avatar'     => $this->meta->avatar ?? null,
            'meta'       => $this->meta,
            'created_at' => $this->created_at,
        ];
    }
}
