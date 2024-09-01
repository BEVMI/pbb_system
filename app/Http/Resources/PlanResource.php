<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {   
        $carbon = Carbon::parse($this->dPlanDate)->format('Y-m-d');
        $rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);

        if($this->nQty==null):
            $post_qty = '';
            $qty = 0;
        else:
            $post_qty = ' - '.$this->nQty;
            $qty = $this->nQty;
        endif;

        return [
            'id'=> $this->id,
            'title'=>$this->cStockCode.$post_qty,
            'start'=>strval($carbon),
            'end'=>strval($carbon),
            'plan_date'=>$carbon,
            'plan_qty'=>$qty,
            'color'=>'#'.$rand,
            'stock_code'=>$this->cStockCode
        ];
    }
}
