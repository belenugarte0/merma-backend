<?php

namespace App\Http\Resources\Role;

use App\Http\Resources\Product\ProductCollection;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullRoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $roles = Role::find($this->id)->roles;

        return [
            "id" => $this->id,
            "name" => $this->name
        ];
    }
}
