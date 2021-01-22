<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DBmaker extends Model
{
    use HasFactory;

    
    public $function;
    public $columns;
    public $table;
    public $statement;
    public $statementColumns;
    public $data;
    public $leftJoin;
    public $order;

    //setters
    public function setFunction($function){
        $this->function = $function;
    }

    public function setColumns($columns){
        $this->columns = $columns;
    }

    public function setTable($table){
        $this->table = $table;
    }

    public function setStatement($statement){
        $this->statement = $statement;
    }

    public function setStatementColumns($statementColumns){
        $this->statementColumns = $statementColumns;
    }

    public function setData($data){
        $this->data = $data;
    }

    public function setLeftJoin(array $leftJoin){
        $this->leftJoin = $leftJoin;
    }

    public function setOrder($order){
        $this->order = $order;
    }

    //getters
    public function getFunction(){
        return $this->function;
    }
    
    public function getColumns(){
        return $this->columns;
    }

    public function getTable(){
        return $this->table;
    }

    public function getStatement(){
        return $this->statement;
    }

    public function getStatementColumns(){
        return $this->statementColumns;
    }

    public function getData(){
        return $this->data;
    }

    public function getLeftJoin(){
        return $this->leftJoin;
    }

    public function getOrder(){
        return $this->order;
    }


    public function mount(){
        if(isset($this->function)){
            if(isset($this->columns)){
                if(isset($this->table)){
                    $return = DB::table($this->table);
                    $valuesColumns = [];
                    foreach ($this->columns as $key => $value){
                        $valuesColumns[$key] = $value;
                    }
                    $return->select($valuesColumns);
                    
                    if(isset($this->leftJoin)){
                        $return->leftJoin($this->leftJoin['tableAim'], $this->leftJoin['column1'], $this->leftJoin['symbol'], $this->leftJoin['column2']);
                    }

                    if(isset($this->statement)){
                        
                        if($this->statement == "where"){
                            $return->where($this->statementColumns,$this->data);
                        }
                        if($this->statement == "whereIn"){
                            $values = [];
                            foreach ($this->statementColumns[1] as $key => $value){
                                $values[$key] = $value;
                            }
                            $return->whereIn($this->statementColumns[0], $values);
                        }
                        if($this->statement == "whereAnd"){
                            foreach ($this->statementColumns as $key => $value){
                                $return->where($value,$this->data[$key]);
                            }
                        }
                    }

                    if(isset($this->order)){
                        $return->orderBy($this->order[0], $this->order[1]);
                    }
                    
                    return $return->get()->all();

                }else{
                    return 'no table set';
                }
            }else{
                return 'no columns set';
            }
        }else{
            return 'no function set';
        }
    }
}
