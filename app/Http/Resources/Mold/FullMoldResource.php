<?php

namespace App\Http\Resources\Mold;

use App\Http\Resources\Product\ProductCollection;
use App\Models\Mold;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullMoldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $products = Mold::find($this->id)->products;

        return [
            "id" => $this->id,
            "code_mold" => $this->code_mold,
            "name_mold" => $this->name_mold,
            "width" => $this->width,
            "height" => $this->height,            
            "status" => $this->status,
        ];
    }
}
