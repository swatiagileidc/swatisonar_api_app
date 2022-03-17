<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class FileUploadApiController extends Controller
{
    public function fileUpload(Request $request)
    {
        try {
            if (request('image')) {
                $base64_str = substr($request->image, strpos($request->image, ",") + 1);
                //decode base64 string
                if ($request->width > 1600) {
                    $image_data = base64_decode($base64_str);
                    $image = Image::make($image_data)->resize($request->width, $request->height, function ($constraint) {
                        $constraint->aspectRatio();
                    })->stream('png', 100);
                } else {
                    $image = base64_decode($base64_str);
                }

                $folderName = $request->folder;
                $safeName = Str::uuid() . '.' . $request->extension;
                $filename = $request->filename.'.' . $request->extension;
             
                Storage::disk('public')->put($folderName . '/' . $safeName, $image);
                
                $filewithpath = "/storage/" . $folderName . '/' . $safeName;

                $status = 'S';
                $message = 'File uploaded succussfully';
            } else {
                $status = 'E';
                $filewithpath = '';
                $message = 'File size is too large';
            }
            return response()->json(['status' => $status, 'message' => $message, 'filepath' => $filewithpath ,'filename'=> $filename]);
        } catch (Exception $file_exception) {
            return response()->json(['status' => 'E', 'message' => 'Error uploading file']);
        }
    }
}
