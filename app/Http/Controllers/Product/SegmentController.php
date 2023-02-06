<?php

namespace App\Http\Controllers\Product;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product\Segment;

class SegmentController extends Controller
{
    public function getSegments()
    {
        $segment = new Segment;
        $sql = $segment->all();
        
        if($sql != '')
        {
            return $sql;
        }
        else {
            return response()->json(['message' => 'No data']);
        }
    }
    
}
