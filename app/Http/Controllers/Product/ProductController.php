<?php

namespace App\Http\Controllers\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product\Product;

class ProductController extends Controller
{
    public function addProduct(Request $request)
    {
        $product = new Product;
        $product->barcode = $request->input('code');
        $product->name = $request->input('name');
        $product->price_bought = str_replace(",","",$request->input('price_bought'));
        $product->price_sale = str_replace(",","",$request->input('price_sale'));
        $product->stock = str_replace(",","",$request->input('quantity'));
        $product->id_category = $request->input('category');
        $product->id_subcategory = $request->input('subcategory');
        $product->id_segment = $request->input('segment');
        $product->discount = str_replace(",","",$request->input('discount'));
        $sql = $product->save();

        //return $request;
        if($sql)
        {
            return response()->json(['message' => 'saved', 'levelNotification' => '1'], 201);
        }
        else {
            return response()->json(['error' => 'data havent been saved','levelNotification' => '2'], 200);
        }
        
    }

    public function updateProduct(Request $request)
    {
        $product = Product::find($request->input('id_product'));

        $product->barcode = $request->input('code');
        $product->name = $request->input('name');
        $product->price_bought = str_replace(",","",$request->input('price_bought'));
        $product->price_sale = str_replace(",","",$request->input('price_sale'));
        $product->stock = str_replace(",","",$request->input('quantity'));
        $product->id_category = $request->input('category');
        $product->id_subcategory = $request->input('subcategory');
        $product->id_segment = $request->input('segment');
        $product->discount = str_replace(",","",$request->input('discount'));
        $sql = $product->save();


        if($sql)
        {
            return response()->json(['message' => 'updated', 'levelNotification' => '1'], 201);
        }
        else {
            return response()->json(['error' => 'error in update','levelNotification' => '2'], 200);
        }

        
    }

    public function getProducts()
    {
        $product = new Product;
        return DB::table('products')->paginate(20);
    }

    public function getSearchProducts(Request $request, $product = '')
    {
        //$product = new Product;
        return DB::table('products')
            ->where('name', 'LIKE',"%{$product}%")
            ->orWhere('barcode','LIKE',"%{$product}%")
            ->paginate(20);
    }

    public function getProductByBarcode($barcode = null)
    {
        $product = DB::table('products')
                        ->where('barcode', $barcode)->first();

        if($product != '')
        {
            return response()->json(['message' => 'ok', 'levelNotification' => '1', 'data' => $product], 201);
        }
        else {
            return response()->json(['error' => 'item did not found','levelNotification' => '2'], 200);
        }
    }
}
