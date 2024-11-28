<?php

namespace App\Http\Resources\Permission;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionCollection extends ResourceCollection
{
    public static $wrap = "permissions";


    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'permissions' => $this->collection->map(function ($permission) {
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'grupo' => $permission->grupo, 
                ];
            }),
        ];    }
}
