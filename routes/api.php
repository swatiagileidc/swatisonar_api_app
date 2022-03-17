<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'App\Http\Controllers', 'as' => 'api.'], function () {
    Route::get('fetch_section', 'SectionsApiController@fetchSection');
    Route::post('save_section', 'SectionsApiController@saveSection');
    Route::get('fetch_section_byid/{id}', 'SectionsApiController@fetchSectionsByid');
    Route::get('parent_sections', 'SectionsApiController@parentChildSections');
    Route::get('delete_section/{id}', 'SectionsApiController@deleteSection');

    //testcases
    Route::get('fetch_testcases', 'TestCasesApiController@fetchTestcases');
    Route::post('save_testcases', 'TestCasesApiController@saveTestCases');
    Route::get('fetch_testcases_byid/{id}', 'TestCasesApiController@fetchTestCaseByid');
    Route::get('delete_testcases/{id}', 'TestCasesApiController@deleteTestCases');

    //fileupload
    Route::post('fileupload', 'FileUploadApiController@fileUpload');

});