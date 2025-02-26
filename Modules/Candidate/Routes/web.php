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
Route::post('/savevideo', 'VideoController@savevideo');
Route::get('/error', 'CandidateController@error404')->name('error');
Route::get('/positionerror', 'LoginController@positionerror')->name('positionerror');
Route::get('/candidateerror', 'LoginController@candidateerror')->name('candidateerror');
Route::get('/unauthenticated', 'LoginController@unauthenticated')->name('unauthenticated');
Route::get('/storagefull', 'LoginController@storagefull')->name('storagefull');
Route::get('/close', 'LoginController@closewindow')->name('closewindow');

Route::get('/testgetBusinessNotifyemail/{app_candidate}', ['uses' => 'CandidateController@testgetBusinessNotifyemail']);

Route::prefix('pid')->group(function() {

    Route::get('/login/{position_id}', 'LoginController@index')->middleware('guestcandidate:candidate','checkemployerstorage:candidate'); //Landing page 
    Route::get('/logout', 'LoginController@logout');
    Route::post('/register', 'CandidateController@register');
    Route::get('/{candid}', 'LoginController@validatelogin')->middleware('checkemployerstorage:candidate','checkposition:candidate'); // Email link to login from candidate
    Route::get('/thankyouregister/{candid}','CandidateController@thankyouregister');
});
Route::post('setqstnsessionindex', 'CandidateController@setQstnIndex');
Route::post('removesession', 'CandidateController@removesession');
Route::post('/otpverify', 'CandidateController@otpverify')->middleware('checkotp:candidate','guestcandidate:candidate'); 
Route::post('/verifyotp','CandidateController@verifyotp');
Route::post('/resendotp','CandidateController@resendotp');
    Route::group(['middleware' => 'candidateauth:candidate'], function () {
        Route::get('/cms', 'CandidateController@cms')->middleware('checkcms:candidate');
        Route::group(['middleware' => 'checkredirect:candidate'], function () {
            Route::get('/overview', 'CandidateController@index');
            Route::get('/ques/{id}', 'CandidateController@qstnDetail');
            Route::post('/updatecompleteqstn', 'CandidateController@updatecompleteqstn');  
            Route::get('/thankyou','CandidateController@thankyoupage');
            Route::post('/runtestsession','CandidateController@runtestsession');
        }); 
        Route::post('/tocontinue', 'CandidateController@tocontinue'); 
        Route::post('/tocontinuename','CandidateController@tocontinuename');

    });
    Route::post('/savecandidatelog', 'CandidateController@savecandidatelog'); 
    //Route::get('{position_id}', 'CandidateController@index');// Landing page
    

