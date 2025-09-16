<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coa;
class CoaController extends Controller
{
    public function upload_coa(Request $request)
    {
        $tos_id = $request->input('tosId');
        $irene = $request->file('file');
        $fileName = time() . '_' . $irene->getClientOriginalName();
        $irene->move(public_path('coas'), $fileName);

        $check = Coa::where('tosId', $tos_id)->first();
        
        $data = array(
            'tosId' => $tos_id,
            'fileName' => $fileName
        );
        if($check):
            unlink(public_path('coas/' . $check->fileName)); // Delete old file
            $check->update($data);
        else:
            Coa::create($data);
        endif;
        return 'success';
        
    }

    public function preview_coa($id)
    {
        $coa = Coa::where('tosId', $id)->first();
        if ($coa) {
            return response()->file(public_path('coas/' . $coa->fileName));
        }
        else{
            return response()->file(public_path('coas/NODATA.pdf'));
        }
    }

    public function coa_view($id)
    {
        $coa = Coa::where('tosId', $id)->first();
        if ($coa) {
            return 1;
        }
        else{
            return 0;
        }
    }
}