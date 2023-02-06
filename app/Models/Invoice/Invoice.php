<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoices';
    protected  $primaryKey = 'id_invoice';

    protected $fillable = [
        'id_invoice',
        'code_invoice',
        'id_customer',
        'discount',
        'total_sale',
        'state',
        'creat_at',
        'updated_at'        
    ];
}
