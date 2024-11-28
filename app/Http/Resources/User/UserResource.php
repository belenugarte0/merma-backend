<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    
    public static $wrap = "user";

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
            "name" => $this->name,
            "lastname" => $this->lastname,
            "document" => $this->document,
            "email" => $this->email,
            "phone" => $this->phone,
            "image" => $this->image,
            "password" => $this->password,
            "role" => $this->getRoleNames()->first(), 
            "status" => $this->status,

        ];
    }
}
