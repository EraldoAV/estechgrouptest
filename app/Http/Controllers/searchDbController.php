<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; 
use Illuminate\Http\Request;
use App\Models\DBmaker;
  
class SearchDbController extends Controller
{
    public $arrReturn;
    public function search()
    {
        // doing search in DB and returning json format
        
        if ($_POST['account'] == ""){

            $dbMaker = new DBmaker();
            $dbMaker->setFunction('select');
            $dbMaker->setColumns(array ('id'));
            $dbMaker->setTable('products');
            $dbMaker->setStatement('whereIn');
            $dbMaker->setStatementColumns(array('sku',explode(",", str_replace(' ', '', $_POST['sku']))));
            $product_id = $dbMaker->mount();
             
            foreach ($product_id as $key => $value){
                $arrIds[$key] = $value->id;
            }

            $leftJoinArr = array(
                'tableAim' => 'products',
                'column1' => 'prices.product_id',
                'symbol' => '=',
                'column2' => 'products.id'
            );

            $dbMaker->setFunction('select');
            $dbMaker->setColumns(array ('prices.value','products.sku'));
            $dbMaker->setTable('prices');
            $dbMaker->setLeftJoin($leftJoinArr);
            $dbMaker->setStatement('whereIn');
            $dbMaker->setStatementColumns(array('product_id',$arrIds));
            $dbMaker->setOrder(array('value','asc'));
            $data = $dbMaker->mount();

            foreach ($data as $key => $value){
                $this->arrReturn[$key] = array(
                    'sku' => $value->sku,
                    'account' => 0,
                    'price' => $value->value
                );
            }

            return (json_encode($this->arrReturn));

        }else{
            
            $dbMaker = new DBmaker();
            $dbMaker->setFunction('select');
            $dbMaker->setColumns(array ('id'));
            $dbMaker->setTable('products');
            $dbMaker->setStatement('where');
            $dbMaker->setStatementColumns('sku');
            $dbMaker->setData($_POST['sku']);
            $product_id = $dbMaker->mount();

            $dbMaker->setFunction('select');
            $dbMaker->setColumns(array ('id'));
            $dbMaker->setTable('accounts');
            $dbMaker->setStatement('where');
            $dbMaker->setStatementColumns('external_reference');
            $dbMaker->setData($_POST['account']);
            $account_id = $dbMaker->mount();

            $dbMaker->setFunction('select');
            $dbMaker->setColumns(array ('id','product_id', 'account_id', 'value'));
            $dbMaker->setTable('prices');
            $dbMaker->setStatement('whereAnd');
            $dbMaker->setStatementColumns(array('product_id','account_id'));
            $dbMaker->setData(array($product_id[0]->id,$account_id[0]->id));

            $data = $dbMaker->mount();

            if(!empty($data)){
                foreach ($data as $key => $value){

                    $this->arrReturn[$key] = array(
                        'sku' => $_POST['sku'],
                        'account' => $_POST['account'],
                        'price' => $value->value
                    );
                }
                
            }else{
                $this->arrReturn = 0;
            }
            return (json_encode($this->arrReturn));
        }
    }
   
}
