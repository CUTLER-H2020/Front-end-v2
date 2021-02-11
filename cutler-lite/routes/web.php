<?php

use App\Models\DebimeterData;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('service-json-decode', function () {
    DebimeterData::where('tarih', 'LIKE', '%'.\Carbon\Carbon::now()->format('Y.m.d').'%')->delete();

    $url = "http://212.174.37.100:8080/abbdata/webservice/service.jsp?ServisID=ODg4OQ==&Token=e3c4d052f8adf75d34f76b1bf24f9f57d41d8cd98f00b204e9800998ecf8427e&Tarih=". \Carbon\Carbon::now()->format('Y.m.d');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));
    $result=curl_exec($ch);
    curl_close($ch);
    $definitionResults = json_decode($result, true);

    foreach ($definitionResults as $definitionResult){
        $instantFlow = number_format(intval(str_replace(';', '', $definitionResult['reg4'])) * 65536 + intval(str_replace(';', '', $definitionResult['reg5'])), intval(str_replace(';', '', $definitionResult['reg3'])), ',', '');
        $actualFlow = number_format(intval(str_replace(';', '', $definitionResult['reg6'])) * 65536 + intval(str_replace(';', '', $definitionResult['reg9'])), intval(str_replace(';', '', $definitionResult['reg3'])), ',', '');

        DebimeterData::create([
            'kayitid' => $definitionResult['kayitid'],
            'islemtarihi' => $definitionResult['islemtarihi'],
            'tarih' => $definitionResult['tarih'],
            'istekid' => $definitionResult['istekid'],
            'kutuid' => $definitionResult['kutuid'],
            'gelenipadresi' => $definitionResult['gelenipadresi'],
            'reg0' => intval(str_replace(';', '', $definitionResult['reg0'])),
            'reg1' => intval(str_replace(';', '', $definitionResult['reg1'])),
            'reg2' => intval(str_replace(';', '', $definitionResult['reg2'])),
            'reg3' => intval(str_replace(';', '', $definitionResult['reg3'])),
            'reg4' => intval(str_replace(';', '', $definitionResult['reg4'])),
            'reg5' => intval(str_replace(';', '', $definitionResult['reg5'])),
            'reg6' => intval(str_replace(';', '', $definitionResult['reg6'])),
            'reg7' => intval(str_replace(';', '', $definitionResult['reg7'])),
            'reg8' => intval(str_replace(';', '', $definitionResult['reg8'])),
            'reg9' => intval(str_replace(';', '', $definitionResult['reg9'])),
            'instant_flow' => intval($instantFlow),
            'actualFlow' => intval($actualFlow),
        ]);
    }



});

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

Route::get('/', function () {
    return redirect('login');
});

Route::get('/forgot-my-password', function () {
    return view('auth.forget-my-password');
});

Route::prefix('admin')->middleware('auth')->group(function (){
    Route::get('dashboard', 'Admin\DashboardController@index')->name('dashboard');
    Route::post('getOnlineUsersCount', 'Admin\DashboardController@getOnlineUsersCount')->name('getOnlineUsersCount');

    Route::prefix('user')->group(function (){
        Route::get('index', 'Admin\UserController@index')->name('user.index');
        Route::get('create', 'Admin\UserController@create')->name('user.create');
        Route::post('store', 'Admin\UserController@store')->name('user.store');
        Route::get('{userID}', 'Admin\UserController@edit')->name('user.edit');
        Route::post('{userID}/update', 'Admin\UserController@update')->name('user.update');
        Route::get('{userID}/delete', 'Admin\UserController@destroy')->name('user.destroy');
    });

    Route::prefix('user-group')->group(function (){
        Route::get('index', 'Admin\UserGroupController@index')->name('user-group.index');
        Route::get('index/{parent_id}', 'Admin\UserGroupController@index')->name('user-group.subIndex');
        Route::get('create/{parent_id}', 'Admin\UserGroupController@create')->name('user-group.create');
        Route::post('store', 'Admin\UserGroupController@store')->name('user-group.store');
        Route::get('{userGroupId}', 'Admin\UserGroupController@edit')->name('user-group.edit');
        Route::post('{userGroupId}/update', 'Admin\UserGroupController@update')->name('user-group.update');
        Route::get('{userGroupId}/delete', 'Admin\UserGroupController@destroy')->name('user-group.destroy');
    });

    Route::prefix('policy')->group(function (){
        Route::get('index', 'Admin\PoliciesController@index')->name('policy.index');
        Route::get('create', 'Admin\PoliciesController@create')->name('policy.create');
        Route::post('store', 'Admin\PoliciesController@store')->name('policy.store');
        Route::get('{policyId}/edit', 'Admin\PoliciesController@edit')->name('policy.edit');
        Route::post('{policyId}/update', 'Admin\PoliciesController@update')->name('policy.update');
        Route::get('{policyId}/delete', 'Admin\PoliciesController@destroy')->name('policy.destroy');

        Route::get('{policyId}/{policyName}/go-to-process', 'Admin\PoliciesController@goToProcess')->name('policy.goToProcess');
    });

    Route::prefix('policy2')->group(function (){
        Route::get('index', 'Admin\Policies2Controller@index')->name('policy2.index')->middleware('permission:policy2.index');
    });

    Route::prefix('process')->group(function (){
        Route::get('{policyId}/index', 'Admin\ProcessController@index')->name('process.index');

        Route::post('startNewProcessModal', 'Admin\ProcessController@startNewProcessModal')->name('startNewProcessModal');
        Route::post('startNewProcess', 'Admin\ProcessController@startNewProcess')->name('startNewProcess');
        Route::post('startNewProcessOnClickModal', 'Admin\DashboardController@buttonOnClick')->name('buttonOnClick'); //Tüm buton eventleri için geçerli olacak
        Route::post('writeAllTasksToDatabase', 'Admin\ProcessController@writeAllTasksToDatabase')->name('writeAllTasksToDatabase');
        Route::post('saveWidget', 'Admin\ProcessController@saveWidget')->name('saveWidget');
        Route::post('deleteWidget', 'Admin\ProcessController@deleteWidget')->name('deleteWidget');
        Route::get('startNewProcessByPass', 'Admin\ProcessController@startNewProcessByPass')->name('startNewProcessByPass');

        Route::post('get-user-process', 'Admin\ProcessController@getUserProcess')->name('getUserProcess');
        Route::post('get-all-process', 'Admin\ProcessController@getAllProcess')->name('getAllProcess');

        Route::get('delete-process/{instanceId}', 'Admin\ProcessController@deleteProcess')->name('deleteProcess');
    });

    Route::prefix('profile')->group(function (){
        Route::get('change-password', 'Admin\ProfileController@changePasswordView')->name('change-password');
        Route::post('change-password', 'Admin\ProfileController@changePasswordUpdate')->name('change-password-update');
    });

    Route::prefix('task')->group(function (){
        Route::get('{xmlProcessId}/{xmlInstanceId}/index', 'Admin\TaskController@index')->name('task.index');
        Route::get('{taskId}/{xmlProcessId}/{processName}/{instanceId}/finish', 'Admin\TaskController@finish')->name('task.finish');
        Route::get('{taskId}/{xmlProcessId}/{processName}/{instanceId}/finishAndNextTask', 'Admin\TaskController@finishAndNextTask')->name('task.finishAndNextTask');
        Route::post('{taskId}/{xmlProcessId}/{processName}/{instanceId}/submitFormAndNextTask', 'Admin\TaskController@submitFormAndNextTask')->name('task.submitFormAndNextTask');

        Route::post('writeFirstTasksToDatabase', 'Admin\TaskController@writeFirstTasksToDatabase')->name('writeFirstTasksToDatabase');
        Route::get('{xmlTaskId}/{xmlProcessId}/{xmlTaskName}/show', 'Admin\TaskController@show')->name('task.show');
        Route::get('{xmlTaskId}/{xmlProcessId}/{xmlInstanceId}/{xmlTaskName}/completedTaskShow', 'Admin\TaskController@completedTaskShow')->name('completedTaskShow');
        Route::post('addComment', 'Admin\TaskController@addComment')->name('task.addComment');
    });

    Route::prefix('process-design')->group(function (){
        Route::get('index', 'Admin\ProcessDesignController@index')->name('process-design.index');
        Route::post('getSelectedWidgets', 'Admin\ProcessDesignController@getSelectedWidgets')->name('getSelectedWidgets');
        Route::post('getUser', 'Admin\ProcessDesignController@getUser')->name('getUser');
    });

    Route::prefix('process-design2')->namespace('Admin\ProcessDesign')->as('process-design2.')->group(function (){
        Route::get('index', 'ProcessDesignController@index')->name('index')->middleware('permission:process-design.index');
        Route::get('detail/{taskKey}', 'ProcessDesignController@detail')->name('detail');
        Route::get('get-tasks', 'ProcessDesignController@getTasks')->name('tasks');
        Route::post('add-widget-to-task', 'ProcessDesignController@addWidgetToTask')->name('add-widget-to-task');
        Route::post('assignProcessToPolicy', 'ProcessDesignController@assignProcessToPolicy')->name('assignProcessToPolicy');
        Route::post('getSelectedPolicy', 'ProcessDesignController@getSelectedPolicy')->name('getSelectedPolicy');
        Route::post('processImageUpload', 'ProcessDesignController@processImageUpload')->name('processImageUpload');
        Route::post('dashboardPreviewModel', 'ProcessDesignController@dashboardPreviewModel')->name('dashboardPreviewModel');
    });

    Route::prefix('settings')->group(function (){
        Route::get('edit', 'Admin\SettingController@edit')->name('settings.edit');
        Route::post('update', 'Admin\SettingController@update')->name('settings.update');
    });

    Route::prefix('kafka')->group(function (){
        Route::get('messages', 'Admin\KafkaController@messages')->name('kafka.messages');
        Route::get('topics', 'Admin\KafkaController@topics')->name('kafka.topics');
    });

    Route::prefix('python')->group(function (){
        Route::post('index', 'Admin\PythonController@index')->name('python.index');
        Route::get('kafka', 'Admin\PythonController@kafka')->name('python.kafka');
        Route::post('kafkaPost', 'Admin\PythonController@kafkaPost')->name('python.kafkaPost');
        Route::post('kafkaKeywords', 'Admin\PythonController@kafkaKeywords')->name('python.kafkaKeywords');
    });

    Route::prefix('language')->group(function (){
        Route::get('index', 'Admin\LanguageController@index')->name('language.index');
        Route::get('status-change/{id}/{status}', 'Admin\LanguageController@statusChange')->name('language.statusChange');
        Route::get('translations', 'Admin\LanguageController@translations')->name('language.translations');
        Route::get('translations-table', 'Admin\LanguageController@translationsTable')->name('language.translationsTable');
        Route::post('translation-modal', 'Admin\LanguageController@translationModal')->name('language.translationModal');
        Route::post('translation-save', 'Admin\LanguageController@translationSave')->name('language.translationSave');
    });
});

Route::get('documentation', function (){
    return view('admin.documentation');
})->name('documentation');

Auth::routes();

Route::post('get-tasks', 'Admin\ProcessDesignController@getTasks')->name('getTasks');
Route::get('/home', 'HomeController@index')->name('home');


Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
})->name('locale');
