<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function createFile()
    {
        //Storage::disk('local')->put('example.txt', 'Contents');
        $contents = Storage::get('example.txt');
        return Storage::download('example.txt');
        //return $contents;
    }

    public function uploadFile(Request $request)
    {
        //$request->file('photo')->put('profile');
        return Storage::put('/public/images', $request->file('photo'));//It returns de url of the uploaded file
    }

    public function downloadFile()
    {
        return Storage::download('public/DeviceDRL1.ino.d1.bin');
        //Storage::disk('local')->put('example.txt', 'Contents');
    }
}
