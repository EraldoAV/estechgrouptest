<?php

namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Exports\DataExport;
use App\Imports\DataImport;
use Maatwebsite\Excel\Facades\Excel;

  
class ExcelFuncsController extends Controller
{
    public function homeView()
    {
        return view('home');
    }
   
    /*
        EXPORT FUNC - ONLY TO STUDY

        public function export() 
        {
            return Excel::download(new UsersExport, 'users.xlsx');
        }
        
    */
   
    public function import() 
    {
        $import = new DataImport();
        $return = Excel::import($import,request()->file('file'));
        $status = $import->getReturn();
        
        if(isset($status)){
            return redirect('/')->with('success', '1');
        }else{
            return redirect('/')->with('fail', '1');
        }
        
    }
}
