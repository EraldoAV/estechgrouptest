<?php

namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
  
class JsonLiveController extends Controller
{
    public function load()
    {
        // Reading File JSON
        $jsonString = file_get_contents(base_path('import_archives/live_prices.json'));
        return json_decode($jsonString, true);
    }
   
}
