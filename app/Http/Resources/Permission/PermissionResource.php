<?php

namespace App\Http\Resources\Permission;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    
    public static $wrap = "permission";

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $products = Permission::find($this->id)->products;

        return [
            "id" => $this->id,
            "name" => $this->name
            
        ];
    }
}
