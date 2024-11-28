<?php

namespace App\Http\Resources\Mold;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MoldResource extends JsonResource
{
    
    public static $wrap = "mold";

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "id" => $this->id,
            "code_mold" => $this->code_mold,
            "name_mold" => $this->name_mold,
            "width" => $this->width,
            "height" => $this->height,
            "status" => $this->status,
            "created_at" => $this->created_at->toDateTimeString(),
            "updated_at" => $this->updated_at->toDateTimeString(),
        ];
    }
}
