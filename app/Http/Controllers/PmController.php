<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('sqlsrv.ClientBufferMaxKBSize','1000000'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','1000000');
use Illuminate\Http\Request;
use App\Models\Month;
use Illuminate\Support\Facades\Http;
use Auth;
class PmController extends Controller
{
    public function index(Request $request){
        $months = Month::all();
        $line_post = $request->input('line');
        if(empty($line_post)):
            $line = '1';
        else:
            $line = $line_post;
        endif;
        $api_url =  env('API_URL');
        $response = Http::get($api_url.'/Inventory/GetFGStockCodes');
        $pm_flag = '1';
        $stockcodes_resource = $response->object();
        $stock_codes[] = 'NO_STOCK_CODE';
        foreach($stockcodes_resource as $row):
            $stock_codes[] =$row->cStockCode;
        endforeach;
        $response_line = Http::get($api_url.'/Production/GetLines');
        $lines = $response_line->object();
        return view('pm.index',compact('months','line','stock_codes','pm_flag','lines'));
    }

    public function mass_date($from_date,$to_date,$remarks,$year,$month,$line){
        $from_date = $from_date.'T00:00:00';
        $to_date = $to_date.'T00:00:00';
        $remarks = $remarks;
        $api_url = env('API_URL');
        $year = $year;
        $month = $month+1;
        $line = $line;
        
        $user_auth = Auth::user();

        $response_line = Http::get($api_url.'/MonthlyPlan/GetMonthlyPlan?nYear='.$year.'&nMonth='.$month.'&nLineNo='.$line);
        $monthly_plans = $response_line->object();
        foreach($monthly_plans as $monthly_plan):
            if(($monthly_plan->dPlanDate>= $from_date) && ($monthly_plan->dPlanDate<=$to_date)):
                Http::post($api_url.'/MonthlyPlan/ApprovedPmMonthlyPlan?iPlanId='.$monthly_plan->id.'&cPmApprovedBy='.$user_auth->name.'&cRemarks='.$remarks);
            endif;
        endforeach;

        return 'irene';
        
    }
}
