<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer\Customer;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class CustomerController extends Controller
{
    public function addCustomer(Request $request)
    {
        $customer = new Customer;
        $customer->name = $request->input('name');
        $customer->identification = $request->input('identification');
        $sql = $customer->save();

        if($sql)
        {
            return response()->json(['message' => 'saved', 'levelNotification' => '1'], 201);
        }
        else {
            return response()->json(['error' => 'data havent been saved','levelNotification' => '2'], 200);
        }
    }

    public function updateCustomer(Request $request) 
    {
        $customer = Customer::find($request->input('id_customer'));
        $customer->name = $request->input('name');
        $sql = $customer->save();

        if($sql)
        {
            return response()->json(['message' => 'saved', 'levelNotification' => '1'], 201);
        }
        else {
            return response()->json(['error' => 'data havent been saved','levelNotification' => '2'], 200);
        }
    }

    public function findCustomer($idCustomer = null)
    {
        
        if(!isNull($idCustomer))
        {
            error_log("null");
            return DB::table('customers')->paginate(20);
        }
        else
        {
            error_log("con datos");
            return DB::table('customers')
                ->where('identification', 'LIKE',"%{$idCustomer}%")
                ->orWhere('name','LIKE',"%{$idCustomer}%")
                ->paginate(20);
        }
    }
}
