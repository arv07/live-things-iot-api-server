<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected  $primaryKey = 'id_product';

    protected $fillable = [
        'name',
        'barcode',
        'id_category',
        'id_subcategory',
        'id_segment',
        'stock',
        'price_bought',
        'price_sale',
        'discount'     
    ];
}
