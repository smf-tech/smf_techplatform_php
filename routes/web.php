<?php

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/','PagesController@index');

Route::get('/about','PagesController@about');

Route::get('/services','PagesController@services');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(
    ['middleware'=>'auth'],
    function(){
    Route::get('/admin',
    ['as'=>'admin.index',
     'uses'=> function(){
        return view('admin.index');
    }
   ]);
    Route::resource('role','RoleController');
    Route::resource('organisation','OrganisationController');
    Route::resource('users','UserController');
    Route::resource('state','StateController');
    Route::resource('jurisdiction','JurisdictionController');
    Route::resource('district','DistrictController');
    Route::resource('taluka','TalukaController');
    Route::resource('cluster','ClusterController');
    Route::resource('village','VillageController');
    Route::resource('orgManager','orgManager');
    Route::get('{org_id}/{module_id}','ModuleManagerController@getModuleData')->where(['org_id' => '[0-9]+', 'module_id' => '[0-9]+']);


    Route::get('{orgId}/forms/create', 'SurveyController@showCreateForm');

    Route::post('/savebuiltform','SurveyController@saveSurveyForm');
    Route::get('{orgId}/forms','SurveyController@index');
    Route::get('{orgId}/roles','OrganisationController@orgroles');
    Route::get('{orgId}/roles/{role_id}',['as'=>'roleconfig','uses'=>'OrganisationController@configureRole']);
    Route::post('/updateroleconfig/{role_id}','OrganisationController@updateroleconfig');

    Route::post('{orgId}/{id}/getSurvey','SurveyController@display');
    Route::post('{orgId}/{id}/results','SurveyController@viewResults');

    Route::get('/{orgId}/{surveyId}/sendResponse','SurveyController@sendResponse');

   });

Route::group(['middleware' => [CheckAuth::class]], function () { 
    Route::get('/getRoles','RoleController@getOrgRoles');
    Route::get('/getJurisdiction','StateController@getJurisdiction');
    Route::get('/getLevel','UserController@getLevel');
    Route::get('/getJidandLevel','TalukaController@getJidandLevel');
    Route::get('/populateData','TalukaController@populateData');

});

Route::get('/settings', 'SettingsController@index')->name('settings');



Route::get('/sendOTP','smsAuthController@sendOTP');
Route::get('/verifyOTP','smsAuthController@verifyOTP');
Route::get('/getTestEndpoint','smsAuthController@getTestEndpoint');
Route::get('/projects','OrganisationController@getProjects');