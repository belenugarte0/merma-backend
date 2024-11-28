<?php

namespace App\Http\Resources\Board;

use App\Http\Resources\Product\ProductCollection;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullBoardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $products = Board::find($this->id)->products;

        return [
            "id" => $this->id,
            "code_board" => $this->code_board,
            "location" => $this->location,
            "width" => $this->width,
            "height" => $this->height,            
            "status" => $this->status,
        ];
    }
}
