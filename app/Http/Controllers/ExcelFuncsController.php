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
        Excel::import(new DataImport,request()->file('file'));
        return redirect('/')->with('success', 'All good!');
    }
}
