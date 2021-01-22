<?php

namespace App\Imports;
   

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use App\Models\DBmaker;
use App\Models\Prices;

class DataImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Prices|null
     */

    public $return;

    public function setReturn($return){
        $this->return = $return;
    }

    public function getReturn(){
        return $this->return;
    }
    
    public function model(array $row)
    {
        $dbMaker = new DBmaker();

        if(isset($row['sku'])){

            //Products ID
            $dbMaker->setFunction('select');
            $dbMaker->setColumns(array ('id'));
            $dbMaker->setTable('products');
            $dbMaker->setStatement('where');
            $dbMaker->setStatementColumns('sku');
            $dbMaker->setData($row['sku']);
            $product_id = $dbMaker->mount();

            //Accounts ID
            $dbMaker->setFunction('select');
            $dbMaker->setColumns(array ('id'));
            $dbMaker->setTable('accounts');
            $dbMaker->setStatement('where');
            $dbMaker->setStatementColumns('external_reference');
            $dbMaker->setData($row['account_ref']);
            $account_id = $dbMaker->mount();

            //Users ID
            $dbMaker->setFunction('select');
            $dbMaker->setColumns(array ('id'));
            $dbMaker->setTable('users');
            $dbMaker->setStatement('where');
            $dbMaker->setStatementColumns('external_reference');
            $dbMaker->setData($row['user_ref']);
            $user_id = $dbMaker->mount();

            $result = new Prices([
                'product_id'     => (!empty($product_id) ? $product_id[0]->id : null), 
                'account_id'     => (!empty($account_id) ? $account_id[0]->id : null), 
                'user_id'        => (!empty($user_id) ? $user_id[0]->id : null), 
                'quantity'       => (isset($row['quantity']) ? $row['quantity'] : null), 
                'value'          => (isset($row['value']) ? $row['value'] : null), 
            ]);

            $this->setReturn($result);

            return($result);
        }else{
            $this->setReturn(null);
            return($this->getReturn());
        }
    }
}