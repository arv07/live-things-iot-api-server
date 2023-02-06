<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $table = 'invoice_details';
    protected  $primaryKey = 'id_invoice_detail';

    protected $fillable = [
        'id_invoice',
        'id_product',
        'quantity'
    ];
}
