<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SectionsApiController extends Controller
{
    public function fetchSection()
    {
        try
        {
            $sections = Sections::orderBy('created_at', 'desc')->get();
            return response()->json(['status' => 'S','message' => 'Data retrived succussfully', 'sections'=>$sections]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'E', 'message' => 'Error processing data']);
        }
    }

    public function saveSection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_name' => 'required|unique:sections,section_name,'.$request->id.'',
        ]);
        try
        {
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()]);
            }
            if($request->id>0){
                $sections = Sections::where('id',$request->id)->update([
                    'section_name'=>$request->section_name,
                    'parent_id'=>$request->parent_id,
                ]);
            }else{
                $sections = Sections::create($request->all());
            }
            return response()->JSON(['status' => 'S', 'message' => 'Data saved succussfully', 'sections' => $sections]);
            
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['status' => 'E', 'message' => 'Error processing data']);
        }
    }

    public function fetchSectionsByid($id){
        try{
            $sections = Sections::find($id);
            return response()->JSON(['status'=>'S','message'=>'Data retrived successfully','sections'=>$sections]);
        }catch(Exception $e){
            return response()->JSON(['status'=>'E','message'=>'Error processing data']);
        }
      
    }

    public function deleteSection($id){
        try{
            $sections = Sections::find($id)->delete();
            return response()->JSON(['status'=>'S','message'=>'Deleted successfully']);
        }catch(Exception $e){
            return response()->JSON(['status'=>'E','message'=>'Error processing data']);
        }
      
    }
    public function parentChildSections(Request $request)
    {
        try {
            $sections = Sections::Where('parent_id', 0)
            ->with('children')
            ->select('id', 'section_name as name')
            ->orderBy('id', 'asc')
            ->get();
            return response()->json(['status' => 'S', 'message' => trans('returnmessage.dataretreived'), 'sections' => $sections]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'E', 'message' => trans('returnmessage.error_processing'), 'error_data' => $e->getmessage()]);
        }
    }

}
