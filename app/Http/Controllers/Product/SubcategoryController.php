<?php

namespace App\Http\Controllers\Product;
use App\Http\Controllers\Controller;
use App\Models\Product\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function getSubcategories()
    {
        $subcategory = new Subcategory;
        $sql = $subcategory->all();
        
        if($sql != '')
        {
            return $sql;
        }
        else {
            return response()->json(['message' => 'No data']);
        }
    }
}
