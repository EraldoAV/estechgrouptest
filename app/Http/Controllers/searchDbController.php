<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; 
use Illuminate\Http\Request;
use App\Models\Prices;
  
class SearchDbController extends Controller
{
    public function search()
    {
        // doing search in DB and returning json format
        
        if ($_POST['account'] == ""){
            
            $product_id = DB::table('products')
                ->select('id')
                ->whereIn('sku',explode(",", str_replace(' ', '', $_POST['sku'])))
                ->get()
                ->all();
                          
            foreach ($product_id as $key => $value){
                $arrIds[$key] = $value->id;
            }

            $data = DB::table('prices')
                ->select('prices.value','products.sku')
                ->leftJoin('products', 'prices.product_id', '=', 'products.id')
                ->whereIn('product_id',$arrIds)
                ->orderBy('value', 'asc')
                ->get();

            foreach ($data as $key => $value){
                $arrReturn[$key] = array(
                    'sku' => $value->sku,
                    'account' => 0,
                    'price' => $value->value
                );
            }
            
            return (json_encode($arrReturn));

        }else{
            
            $product_id = DB::select('SELECT id FROM products WHERE sku=?', [$_POST['sku']]);
            $account_id = DB::select('SELECT id FROM accounts WHERE external_reference=?', [$_POST['account']]);
            $data = DB::table('prices')
                ->select('id', 'product_id', 'account_id', 'value')
                ->where('product_id', '=', $product_id[0]->id)
                ->where('account_id', '=', $account_id[0]->id)
                ->orderBy('value', 'asc')
                ->get();


            if(isset($data->items)){
                foreach ($data as $key => $value){

                    $arrReturn[$key] = array(
                        'sku' => $_POST['sku'],
                        'account' => $_POST['account'],
                        'price' => $value->value
                    );
                }
            }else{
                $arrReturn = 0;
            }
              
            return (json_encode($arrReturn));
        }
    }
   
}
