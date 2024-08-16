<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Month;
use App\Http\Resources\ForecastResource;
use App\Http\Resources\PbbStockCodeResource;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
ini_set('sqlsrv.ClientBufferMaxKBSize','1000000'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','1000000');

class ForecastController extends Controller
{
    public function index(Request $request){
        $months = Month::all();
        return view('forecast.index',compact('months'));
    }

    public function check(Request $request){
        $irene = $request->file('file');
        
        $extension  = $irene->getClientOriginalExtension();
        
        $validator = Validator::make($request->all(), [
         'file' => 'required|mimes:csv,xlsx,xls'
        ]);
        
        if ($validator->fails()) :
            return 'ERROR';
        else:
           
            if('csv' == $extension):
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            elseif('xlsx' == $extension):
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            elseif('xls' == $extension):
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            elseif('xls' != $extension || 'xlsx' != $extension || 'csv' != $extension ):
                return '2';
            endif;
            
            $spreadsheet = $reader->load($irene->getPathName());
            $sheetDatas = $spreadsheet->getActiveSheet()->toArray();
            $highestRow = $spreadsheet->getActiveSheet()->getHighestColumn();
            $colNumber = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestRow);
            foreach($sheetDatas as $sheetData):
                $stock_code = trim(strtoupper($sheetData[0]));
                $description = trim(strtoupper($sheetData[1]));
                $qty = trim(strtoupper($sheetData[2]));
                
                $data = array(
                    $stock_code,
                    $description,
                    $qty
                );
                
                for ($x = 3; $x < $colNumber-1; $x++):
                    $post = trim(strtoupper($sheetData[$x]));
                    array_push($data,$post);
                endfor;
                $data_2[]= $data;
            endforeach;
            return $data_2;
        endif;
    }

    public function store(Request $request){
        $irene = $request->file('file');
        
        $extension  = $irene->getClientOriginalExtension();
        
        $validator = Validator::make($request->all(), [
         'file' => 'required|mimes:csv,xlsx,xls'
        ]);
        
        if ($validator->fails()) :
            return 'ERROR';
        else:
           
            if('csv' == $extension):
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            elseif('xlsx' == $extension):
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            elseif('xls' == $extension):
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            elseif('xls' != $extension || 'xlsx' != $extension || 'csv' != $extension ):
                return '2';
            endif;
            
            $spreadsheet = $reader->load($irene->getPathName());
            $sheetDatas = $spreadsheet->getActiveSheet()->toArray();
            $highestRow = $spreadsheet->getActiveSheet()->getHighestColumn();
            $column = 'D';
            $data = array();
            $output = array();
            array_shift($sheetDatas);
            for ($x = 3; $x < 1000; $x++):
                $date = strtoupper($spreadsheet->getActiveSheet()->getCell($column.'1')->getFormattedValue());
                
                $month =  ltrim(Carbon::parse($date)->format('m'), '0');
                $year = Carbon::parse($date)->format('Y');
                foreach($sheetDatas as $sheetData):
                    $stock_code = trim(strtoupper($sheetData[0]));
                    $qty = trim(strtoupper($sheetData[$x]));
                    
                    // GLOBAL
                    $replace = str_replace($qty,",","");
                
                    $data[] = array(
                        'id'=>0,
                        'cStockCode'=>$stock_code,
                        'nQty'=>(int)str_replace(',',"",$qty)
                    );
                endforeach;

                $output[] = (object)array(
                    'id'=>0,
                    'nYear'=>$year,
                    'nMonth'=>$month,
                    'StockCodes'=>$data
                );
                $data = array();
                if ($column == $highestRow):
                  break;
                endif;
                $column++;
               
            endfor;
           
           return ForecastResource::collection($output);
        endif;
    }

    public function pbb_stockcode(Request $request){
        $api_url = Config('irene.api_url');
        $search = strtoupper($request->search);
        $response = Http::get($api_url.'/Inventory/GetFGStockCodes?cText='.$search);
        return PbbStockCodeResource::collection($response->object());
    }
}
