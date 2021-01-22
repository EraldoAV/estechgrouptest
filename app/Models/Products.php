<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primaryKey = 'id';

    protected $fillable = [
        'sku',
        'name',
        'discription',
        'price',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
