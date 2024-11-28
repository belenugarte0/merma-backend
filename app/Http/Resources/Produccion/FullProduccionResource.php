<?php

namespace App\Http\Resources\Produccion;

use App\Http\Resources\Product\ProductCollection;
use App\Models\Produccion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FullProduccionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "id" => $this->id,
            "cod_produccion" => $this->cod_produccion,
            "cod_order" => $this->cod_order,
            "merma" => $this->merma,
            "espacio_usado" => $this->espacio_usado,            
            "imagen" => $this->imagen,            
            "status" => $this->status,
        ];
    }
}
