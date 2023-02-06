<?php

namespace App\Http\Controllers\Product;
use App\Http\Controllers\Controller;
use App\Models\Product\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class CategoryController extends Controller
{
    /* public function getCategories()
    {
        $category = new Category;
        $sql = $category->all();

        
        if($sql != '')
        {
            return $sql;
        }
        else {
            return response()->json(['message' => 'No data']);
        }
        
    } */

    public function addCategory(Request $request)
    {
        $category = new Category;
        $category->category = $request->input('category');
        $sql = $category->save();

        if($sql)
        {
            return response()->json(['message' => 'saved', 'levelNotification' => '1'], 201);
        }
        else {
            return response()->json(['error' => 'data havent been saved','levelNotification' => '2'], 200);
        }

    }

    public function updateCategory(Request $request)
    {
        $category = Category::find($request->input('id_category'));

        $category->category = $request->input('category');
        $sql = $category->save();

        if($sql)
        {
            return response()->json(['message' => 'updated', 'levelNotification' => '1'], 201);
        }
        else {
            return response()->json(['error' => 'error in update','levelNotification' => '2'], 200);
        }
    }


    public function getCategories()
    {
        //$product = new Product;
        return DB::table('categories')->paginate(20);
    }

    
}
