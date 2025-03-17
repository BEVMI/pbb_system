<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
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
        $api_url = env('API_URL');
        // $response = Http::get($api_url.'/Production/GetFGStockCodes');

        if($this->bPmApproved === 1):
            if($this->iSysproJob == NULL):
                $color = '#5C4033';
            else:
                $color = '#32de84';
            endif;
        else:
            if($this->iSysproJob == NULL):
                // $color = '#D10000';
                // D10000
                $color = '#5C4033';
            else:
                $color = '#32de84';
            endif;
        endif;

        if($this->iSysproJob == NULL):
            $post_job = '';
        else:
            $post_job = ' (JOB -'.$this->iSysproJob.')';
        endif;

        if($this->nQty==null):
            $post_qty = '';
            $qty = 0;
        else:
            $post_qty = ' - '.$this->nQty;
            $qty = $this->nQty;
        endif;

        if($this->cRemarks == null):
            $c_remarks = ''; 
        else:
            $c_remarks = $this->cRemarks;
        endif;

        return [
            'id'=> $this->id,
            'title'=>$this->cStockCode.$post_qty.$post_job,
            'start'=>strval($carbon),
            'end'=>strval($carbon),
            'plan_date'=>$carbon,
            'plan_qty'=>$qty,
            'color'=>$color,
            'stock_code'=>$this->cStockCode,
            'job'=>$post_job,
            'pm'=>$this->cPmApprovedBy,
            'cRemarks'=>$c_remarks
        ];
    }
}
