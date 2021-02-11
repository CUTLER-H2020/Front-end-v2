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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('cost-data', function (Request $request){
    $userTokenCheck = \App\Models\UsersInfo::whereToken($request->bearer_token)->first();
    if ($userTokenCheck){
        $costData = \App\Models\CostData::all();
        $data['status'] = 1;
        $data['costData'] = $costData;
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }else{
        $data['status'] = 0;
        $data['costData'] = "Token geçerli değil.";
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }
});

Route::post('economic-data', function (Request $request){
    $userTokenCheck = \App\Models\UsersInfo::whereToken($request->bearer_token)->first();
    if ($userTokenCheck){
        $economicData = \App\Models\EconomicData::all();
        $data['status'] = 1;
        $data['economicData'] = $economicData;
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }else{
        $data['status'] = 0;
        $data['costData'] = "Token geçerli değil.";
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }
});

Route::post('users-info', function (Request $request){
    $userTokenCheck = \App\Models\UsersInfo::whereToken($request->bearer_token)->first();
    if ($userTokenCheck){
        $userInfo = \App\Models\UsersInfo::all();
        $data['status'] = 1;
        $data['userInfo'] = $userInfo;
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }else{
        $data['status'] = 0;
        $data['costData'] = "Token geçerli değil.";
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }
});

Route::post('water-data', function (Request $request){
    $userTokenCheck = \App\Models\UsersInfo::whereToken($request->bearer_token)->first();
    if ($userTokenCheck){
        $waterData = \App\Models\WaterData::all();
        $data['status'] = 1;
        $data['waterData'] = $waterData;
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }else{
        $data['status'] = 0;
        $data['costData'] = "Token geçerli değil.";
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }
});
