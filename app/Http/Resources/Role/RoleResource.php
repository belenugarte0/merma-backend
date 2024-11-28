<?php

namespace App\Http\Resources\Role;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    
    public static $wrap = "role";

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $products = User::find($this->id)->products;

        return [
            "id" => $this->id,
            "name" => $this->name            
        ];
    }
}
