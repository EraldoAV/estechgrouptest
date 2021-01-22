<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prices extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = "prices";

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'product_id',
        'account_id',
        'user_id',
        'quantity',
        'value',
    ];
}
