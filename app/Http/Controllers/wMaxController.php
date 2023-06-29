<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\wMaxModel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;

class wMaxController extends Controller
{
    public function wMax(){
        //  $wMax = wMaxModel::get();

        $wMax = DB::connection('sqlsrv')->select("SELECT  [ID],[DateTime], [DepartmentScrap], [Mass], [Operator], [ScaleName] FROM [dbo].[tblCompletedScrap]");
        $disncDep = DB::connection('sqlsrv')->select("SELECT DISTINCT DepartmentScrap FROM [tblCompletedScrap]"); 
        return view('wMax')->with('wMax', $wMax)->with('disncDep', $disncDep);
    }

   public function wMaxCRUD(Request $request)
    {
        $ID = $request->get('ID');
        $DateTime = $request->get('DateTime');
        $DepartmentScrap = $request->get('DepartmentScrap');
        $Mass = $request->get('Mass');
        $Operator = $request->get('Operator');
        $ScaleName = $request->get('ScaleName');
        $prompt = $request->get('prompt');


        //dd($customer_id,$first_name,$last_name,$phone,$email,$street,$city,$state,$zip_code,$prompt);

        $response = DB::connection('sqlsrv')->select("EXEC spwMaxCRUD ?,?,?,?,?,?,?", array( $ID,$DateTime,$DepartmentScrap,$Mass,$Operator,$ScaleName,$prompt));

        return response()->json($response);
    }
}
