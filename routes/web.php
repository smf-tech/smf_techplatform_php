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
    Route::delete('role/{id}', array('as' => 'role.destroy','uses' => 'RoleController@destroy'));
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
    Route::get('/{orgId}/setKeys/{survey_id}','SurveyController@setKeys');
    Route::post('/form/storeKeys','SurveyController@storeKeys');
    Route::get('/{orgId}/editKeys/{survey_id}','SurveyController@editKeys');
    Route::get('{orgId}/forms','SurveyController@index');
    Route::get('{orgId}/roles','OrganisationController@orgroles');
    Route::get('{orgId}/roles/{role_id}',['as'=>'roleconfig','uses'=>'OrganisationController@configureRole']);
    Route::post('/updateroleconfig/{role_id}','OrganisationController@updateroleconfig');

    Route::post('{orgId}/{id}/getSurvey','SurveyController@display');
    Route::post('{orgId}/{id}/results','SurveyController@viewResults');

    Route::get('/{orgId}/{surveyId}/sendResponse','SurveyController@sendResponse');
    Route::get('/projects','OrganisationController@getProjects');

    Route::get('/{orgID}/editForm/{surveyID}','SurveyController@editForm');
    Route::resource('form','SurveyController');
    Route::post('/saveEditedform','SurveyController@saveEditedForm');
    Route::resource('entity','EntityController');
    Route::get('{orgId}/entities','EntityController@index');
    Route::get('{orgId}/entity/create','EntityController@create');
	
    Route::resource('microservice','MicroservicesController');
    Route::get('{orgId}/microservices','MicroservicesController@index');

    Route::resource('category','CategoryController');
    Route::get('{orgId}/categories','CategoryController@index');
    Route::get('{orgId}/category/create','CategoryController@create');

    Route::resource('project','ProjectController');
    Route::get('{orgId}/projects','ProjectController@index');
    Route::get('{orgId}/project/create','ProjectController@create');

        Route::resource('{orgId}/locations','LocationController', [
            'parameters' => ['location' => 'locationId'],
        ]);
   });  

Route::group(['middleware' => [CheckAuth::class]], function () { 
    Route::get('/getRoles','RoleController@getOrgRoles');
    Route::get('/getJurisdiction','StateController@getJurisdiction');
    Route::get('/getLevel','UserController@getLevel');
    Route::get('/getJidandLevel','TalukaController@getJidandLevel');
    Route::get('/populateData','TalukaController@populateData');
    Route::get('/getAjaxOrgId','RoleController@getAjaxOrgId');

});

Route::get('/settings', 'SettingsController@index')->name('settings');



Route::get('/sendOTP','smsAuthController@sendOTP');
Route::get('/verifyOTP','smsAuthController@verifyOTP');
Route::get('/getTestEndpoint','smsAuthController@getTestEndpoint');

