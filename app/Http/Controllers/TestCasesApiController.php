<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use App\Models\TestCases;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
class TestCasesApiController extends Controller
{
    
    public function fetchTestcases(Request $request)
    {
        try
        {
            $testcases = TestCases::orderBy('created_at', 'desc');
            if($request->sectionid !== null){
                $testcases = $testcases->where('section_id',$request->sectionid);
            }
            $testcases = $testcases->get();
            return response()->json(['status' => 'S','message'=>'Data retrived succussfully', 'testcases'=>$testcases]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'E', 'message' => 'Error processing data']);
        }
    }

    public function saveTestCases(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section_id' => 'required',
            'testcase_summary' => 'required',
        ]);
        try
        {
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()]);
            }
            if($request->id>0){
                $testcases = TestCases::where('id',$request->id)->update([
                    'section_id'=>$request->section_id
                    ,'testcase_summary'=>$request->testcase_summary
                    ,'description'=>$request->description
                    ,'filename'=>$request->filename
                    ,'status'=>$request->status
                ]);
            }else{
                $testcases = TestCases::create([
                    'section_id'=>$request->section_id
                    ,'testcase_summary'=>$request->testcase_summary
                    ,'description'=>$request->description
                    ,'filename'=>$request->filename
                    ,'status'=>$request->status
                ]);
            }
            return response()->JSON(['status' => 'S', 'message' => 'Data saved succussfully', 'testcases' => $testcases]);
            
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['status' => 'E', 'message' => 'Error processing data']);
        }
    }

    public function fetchTestCaseByid($id){
        try{
            $testcases = TestCases::find($id);
            return response()->JSON(['status'=>'S','message'=>'Data retrived successfully','testcases'=>$testcases]);
        }catch(Exception $e){
            return response()->JSON(['status'=>'E','message'=>'Error processing data']);
        }
      
    }

    public function deleteTestCases($id){
        try{
            $testcases = TestCases::find($id)->delete();
            return response()->JSON(['status'=>'S','message'=>'Deleted successfully']);
        }catch(Exception $e){
            return response()->JSON(['status'=>'E','message'=>'Error processing data']);
        }
      
    }
}

