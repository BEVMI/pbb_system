<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Month;
use App\Http\Resources\ForecastResource;
use Validator;

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

    public function store(Request $request){
        $month = $request->input('month');
        $year = $request->input('year');
        $irene = $request->file('file');

        $extension  = $irene->getClientOriginalExtension();
        
        $validator = Validator::make($request->all(), [
         'file' => 'required|mimes:csv,xlsx,xls'
        ]);
        
        if ($validator->fails()) :
            return 1111;
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

            $A1 = strtoupper($spreadsheet->getActiveSheet()->getCell('A1')->getValue());
            $B1 = strtoupper($spreadsheet->getActiveSheet()->getCell('B1')->getValue());
            $C1 = strtoupper($spreadsheet->getActiveSheet()->getCell('C1')->getValue());
            if(trim($A1) !='STOCK CODE'):
                return 3;
            endif;

            if(trim($B1) !='QTY'):
                return 3;
            endif;

            if(trim($C1) !='UOM'):
                return 3;
            endif;
            array_shift($sheetDatas);

            $data = array();
            foreach($sheetDatas as $sheetData):
                $stock_code = trim(strtoupper($sheetData[0]));
                $qty = trim(strtoupper($sheetData[1]));
                $uom = trim(strtoupper($sheetData[2]));
                $data[] = array(
                    'id'=>0,
                    'cStockCode'=>$stock_code,
                    'nQty'=>$qty,
                );
            endforeach;

            $output = (object)array(
                'id'=>0,
                'nYear'=>$year,
                'nMonth'=>$month,
                'StockCodes'=>$data
            );
            return new ForecastResource($output);
        endif;
    }
}
