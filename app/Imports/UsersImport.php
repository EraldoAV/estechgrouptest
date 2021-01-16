<?php

namespace App\Imports;
   
use App\Models\Prices;
/*

ELOQUENT PERFORMANCE TEST
use App\Models\Products;
use App\Models\Accounts;
use App\Models\Users;

*/
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
    
class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        // USING NATIVE DB IS FASTER THAN ELOQUENT (<=15 secs of uploading csv file)

        //checking if there's something inside the row to not do a query request in vain
        //if true, do the query and find the respective data inside the variable
        //if false, set null inside the variable
        if (isset($row['sku'])){
            $product_id = DB::select('SELECT id FROM products WHERE sku=?', [$row['sku']]);
        }else{
            $product_id = null;
        }
        if (isset($row['account_ref'])){
            $account_ref = DB::select('SELECT id FROM accounts WHERE external_reference=?', [$row['account_ref']]);
        }else{
            $account_ref = null;
        }
        if (isset($row['user_ref'])){
            $user_ref = DB::select('SELECT id FROM users WHERE external_reference=?', [$row['user_ref']]);
        }else{
            $user_ref = null;
        }
        
        //adding the .csv data in DB
        return new Prices([
           'product_id'     => (isset($product_id) ? $product_id[0]->id : null),
           'account_id'     => (isset($account_ref) ? $account_ref[0]->id : null), 
           'user_id'        => (isset($user_ref) ? $user_ref[0]->id : null), 
           'quantity'       => $row['quantity'], 
           'value'          => $row['value'], 
        ]);

        //ELOQUENT, ONLY TO PERFORMANCE TEST (>=30 secs of uploading csv file),
        /*return new Prices([
            'product_id'     => (isset($row['sku']) ? Products::where('sku', $row['sku'])->get()->first()->id : null),
            'account_id'     => (isset($row['account_ref']) ? Accounts::where('external_reference', $row['account_ref'])->get()->first()->id : null), 
            'user_id'        => (isset($row['user_ref']) ? Users::where('external_reference', $row['user_ref'])->get()->first()->id : null), 
            'quantity'       => $row['quantity'], 
            'value'          => $row['value'], 
         ]);*/
    }
}