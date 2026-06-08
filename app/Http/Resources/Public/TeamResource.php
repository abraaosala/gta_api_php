<?php

namespace App\Http\Resources\Public;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'role' => $this->role,
            'photo' => $this->photo,
            'bio' => $this->bio,
            'social_links' => $this->social_links,
            'sort_order' => $this->sort_order,
            'active' => $this->active,
        ];
    }
}
