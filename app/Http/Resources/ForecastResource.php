<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ForecastResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        static::wrap(null);
        return [
            'id'=> 0,
            'nYear' => $this->nYear,
            'nMonth' => $this->nMonth,
            'StockCodes' => $this->StockCodes,
        ];
    }
}
