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

Route::get('/getactivexpemp','CronController@getactivexpemp');

Route::get('/updateappidbyemail','CronController@updateappidbyemail');

Route::get('/updateappid','CronController@updateappid');

Route::get('/{company_name}/{employer_id}/careers',  'CareerController@index');

Route::get('/empstoragealert',  'CronController@employerStorageAlert');
Route::get('/recordvideodelete',  'CronController@deleteRecordingVidos');
Route::get('/deletebeforesendmail',  'CronController@deleteBeforeSendMail');
Route::get('/expiryemployer',  'CronController@expiryEmployer');
Route::get('/inviteremindermail',  'CronController@interviewEmailRemainders');
Route::get('/updatevideousage',  'CronController@updatevideoUsage');
Route::get('/overallusage',  'CronController@overallUsage');

Route::get('/changevideoformat',  'CronController@changevideoformat');


Route::get('/videotrans',  'CronController@aivideoTrans');

Route::get('/testing', 'LoginController@testing');


Route::prefix('employer')->group(function() {
    Route::get('/appautologin/{empid}', 'LoginController@appautologin');
    Route::get('/autologinaccnt/{empid}', 'LoginController@autologinaccnt');
    Route::get('/checkusername/{email}', ['as' => 'employer.checkusername', 'uses' => 'RegisterController@checkusername'])->middleware('guestemployers:employers');
    Route::get('/login', ['as' => 'employer.login', 'uses' => 'LoginController@index'])->middleware('guestemployers:employers');
    Route::get('/forgotpass', ['as' => 'employer.forgotpass', 'uses' => 'LoginController@forgotpass'])->middleware('guestemployers:employers');
    Route::post('/forgotmail', ['as' => 'employer.forgotmail', 'uses' => 'LoginController@forgotmail'])->middleware('guestemployers:employers');
    Route::get('/password/reset/{id}', 'LoginController@setNewPassword')->middleware('guestemployers:employers');
    Route::get('/settings/getEmployeedetails/{id}', ['as' => 'employer.getEmployeedetails', 'uses' => 'SettingController@getEmployeedetails']);
   
    Route::post('/changepassword', ['as' => 'employer.changepassword', 'uses' => 'LoginController@changePassword'])->middleware('guestemployers:employers');
    
    

    Route::get('/pricing', ['as' => 'employer.pricing', 'uses' => 'RegisterController@pricing'])->middleware('guestemployers:employers');   
    
    Route::get('/logout', ['as' => 'employer.logout', 'uses' => 'LoginController@logout']);
    Route::post('/validatelogin', ['as' => 'employer.validatelogin', 'uses' => 'LoginController@validatelogin']);
    Route::get('/setauthentication/{subuser}',  'SettingController@showsetpass');  
    Route::post('/updatepass',  'SettingController@updatepass'); 
     Route::get('/register/pid/{pid}','RegisterController@create');
     Route::get('/register/pid/{pid}/businessid/{busid}','RegisterController@createfromapp');
     Route::post('/checkemailexist',  'SettingController@validateemail');
     Route::resource('register', 'RegisterController');
     Route::get('/thankyou','RegisterController@thankyoupage');
    Route::group(['middleware' => 'employersauth:employers'], function () {
        Route::get('/', 'PositionController@index')->name('position');
        Route::get('/position/share/{positionid}','PositionController@shareposition');
         Route::post('/position/shareurl',  'PositionController@shareurl')->name('shareurl');
         Route::post('/position/sharedirectinvite',  'PositionController@sharedirectinvite')->name('sharedirectinvite');
         Route::get('/position/duplicate/{positionid}',  'PositionController@duplicatep')->name('duplicatep');
         Route::resource('position', 'PositionController');
          Route::post('/settings/checkidealtraitsuser', ['as' => 'employer.checkidealtraitsuser', 'uses' => 'SettingController@checkidealtraitsuser']); 
          Route::post('/settings/mergeidealtraits', ['as' => 'employer.mergeidealtraits', 'uses' => 'SettingController@mergeidealtraits']); 

         Route::get('/settings/upgradepackage',  'SettingController@upgradepackage');
        // Manage Employers
        Route::resource('manageusers', 'SettingController');
        Route::get('accountsetting','SettingController@accountsettingindex');
        Route::get('companysetting','SettingController@companysettingindex');
        Route::get('careersetting','SettingController@getCareersetting');
        
         
        Route::post('/settings/createsubemployer',  'SettingController@createNewsubemployer'); 
        Route::get('/loadsubusers', ['as' => 'employer.loadsubusers', 'uses' => 'SettingController@loadsubusers']);
        Route::post('/subuser/{userid}',  'SettingController@subuserDelete');
        Route::post('/settings/accountsetting',  'SettingController@accountsetting'); 
        Route::post('/settings/checkoldpass',  'SettingController@checkoldpass'); 
        Route::post('/settings/updateaccountpass',  'SettingController@updateaccountpass');
        Route::get('/settings/upgradepackage',  'SettingController@upgradepackage');
        Route::post('/settings/companysetting',  'SettingController@companysetting');

         Route::get('/candidate/statuscount',  'CandidateController@statuscount');
         Route::post('/candidate/hire',  'CandidateController@hire');
        Route::resource('candidate', 'CandidateController');
        Route::post('/candidate/candidatemassdelete', 'CandidateController@massdelete');
        Route::post('/candidate/candidatemassrestore', 'CandidateController@massrestore');
        Route::post('/candidate/sendmassinvite', 'CandidateController@sendmassinvite');
        Route::get('{positionid}/candidate','CandidateController@index')->name('candidate');
        //Route::get('{positionid}/candidate/view','CandidateController@show');
        Route::get('/candidate/detail/{candidateid}','CandidateController@show');
        Route::get('/candidate/commentsactivity/{candidateid}','CandidateController@commentsactivity');
        Route::get('/candidate/commentlist/{candidate}/{filter?}', ['uses' => 'CandidateController@commentlist']);
        Route::post('/candidate/createactivity', [ 'uses' => 'CandidateController@createactivity']);
        Route::post('/candidate/questioncomment', [ 'uses' => 'CandidateController@questioncomment']);
        Route::get('/loadcandidates', 'CandidateController@loadcandidates');
        Route::post('/candidate/rating',  'CandidateController@ratingupdate');
        Route::post('/candidate/restore',  'CandidateController@restore');
        Route::get('/candidate/download/qid/{qid}/cid/{candidateid}/qindex/{indexid}',  'CandidateController@download');
        Route::get('/candidate/downloadzip/cid/{candidateid}',  'CandidateController@zipVideo');
        Route::post('/addcomments',  'CandidateController@addcomments'); 
        Route::get('/qstncommentlist/{question_id}/{candidate}', ['uses' => 'CandidateController@qstncommentlist']);

       

        


        Route::post('/settings/savebusinesslogo', 'SettingController@savebusinesslogo');
        Route::post('/settings/getlogoimage', 'SettingController@getlogoimage');
        Route::post('/settings/deletebusinesslogo', 'SettingController@deletebusinesslogo');

        Route::post('/settings/careersettingupdate', 'SettingController@careersettingupdate');
        Route::post('/careersetting/getbannerimagefromlibrary', 'SettingController@getbannerimagefromlibrary');
        Route::post('/careersetting/savecompanyphotosfromlib', 'SettingController@savecompanyphotosfromlib');
        Route::post('/careersetting/getbannerimage', 'SettingController@getbannerimage');
        Route::post('/careersetting/savecompanyphotos', 'SettingController@savecompanyphotos');
        Route::get('/careersetting/getdescriptiontemplate', 'SettingController@getdescriptiontemplate');
        Route::post('/careersetting/downloadqr', 'SettingController@downloadqr');

        // All Candidates 
        Route::get('/candidates/statuscount',  'AllCandidatesController@statuscount');
        Route::post('/candidates/hire',  'AllCandidatesController@hire');
        Route::resource('candidates', 'AllCandidatesController');
        Route::get('/loadallcandidates', 'AllCandidatesController@loadcandidates');
        Route::post('/candidates/rating',  'AllCandidatesController@ratingupdate');
        Route::post('/candidates/candidatemassdelete', 'AllCandidatesController@massdelete');
        Route::post('/candidates/candidatemassrestore', 'AllCandidatesController@massrestore');
        Route::post('/candidates/restore',  'AllCandidatesController@restore');
        Route::get('/candidates/detail/{candidateid}','AllCandidatesController@show');
        Route::get('/candidates/commentsactivity/{candidateid}','AllCandidatesController@commentsactivity');
        Route::get('/candidates/commentlist/{candidate}/{filter?}', ['uses' => 'AllCandidatesController@commentlist']);
        Route::post('/candidates/createactivity', [ 'uses' => 'AllCandidatesController@createactivity']);
        Route::post('/candidates/questioncomment', [ 'uses' => 'AllCandidatesController@questioncomment']);
        Route::post('/allcandidaddcomments',  'AllCandidatesController@addcomments'); 
        Route::get('/allcandqstncommentlist/{question_id}/{candidate}', ['uses' => 'AllCandidatesController@qstncommentlist']);
    });
});


