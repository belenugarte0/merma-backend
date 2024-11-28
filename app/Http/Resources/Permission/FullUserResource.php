<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Product\ProductCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'grupo' => $this->grupo,
            'permission_id' => $this->permission_id,
            'role_id' => $this->role_id,
        ];
    }
}
