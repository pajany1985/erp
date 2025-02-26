<?php

use Illuminate\Http\Request;

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

Route::prefix('employer')->group(function() {

    
    Route::post('/getexpappbusid', 'Api\BridgeController@getexpappbusid');

    Route::post('/updemail', 'Api\BridgeController@updemail');
    Route::post('/updcandidateemail', 'Api\BridgeController@updcandidateemail');
    Route::get('/changeformat/{appcandidid}','Api\BridgeController@changeformat');

    Route::get('/getdefaultqstn','Api\BridgeController@getdefaultqstn');
    Route::post('/updateapikey', 'Api\BridgeController@updateapikey');
    Route::post('/mergeapikey', 'Api\BridgeController@mergeapikey');
    Route::get('/videopackage/{email}/{key}',  'Api\BridgeController@videopackage'); 
    Route::get('/pid/{position_id}/cemail/{candidate_email}',  'Api\BridgeController@checkCandidate'); 
    Route::post('/inviteidealCandidate', 'Api\BridgeController@inviteIdealCandidate');

    Route::post('/saveposition', 'Api\BridgeController@saveposition');

    Route::post('/savepositionpopup', 'Api\BridgeController@savepositionpopup');

    
    Route::get('/loadintervpositionall/{email}/{search?}','Api\BridgeController@loadintervpositionall');
    Route::get('/loadintervpositionactive/{email}/{search?}','Api\BridgeController@loadintervpositionActive');
    Route::get('/loadintervpositiondraft/{email}/{search?}','Api\BridgeController@loadintervpositionDraft');
    Route::get('/loadintervpositionarchived/{email}/{search?}','Api\BridgeController@loadintervpositionArchived');

    Route::post('/duplicateposition', 'Api\BridgeController@duplicateposition');
    Route::post('/deleteposition', 'Api\BridgeController@deleteposition');
    Route::get('/getpositioninfo/{positionid}/{employerid}','Api\BridgeController@getpositioninfo');

    Route::post('/updateposition/{positionid}', 'Api\BridgeController@updateposition');
    Route::post('/updatecandidate/{canid}', 'Api\BridgeController@updatecandidate');

    Route::post('/createbussiness', 'Api\BridgeController@createbussiness');
    Route::post('/createbussinessfromappadmin', 'Api\BridgeController@createbussinessfromappadmin');
    Route::post('/createbussinessfrompackage', 'Api\BridgeController@createbussinessfrompackage');

    Route::post('/updateexpirydays', 'Api\BridgeController@updateexpirydays');
    
    Route::get('/getquestions/{positionid}','Api\BridgeController@getquestions');
    Route::get('/resendinvite/{candidate_id}','Api\BridgeController@resendInvite');
    Route::get('/getvideoposition/{position_id}','Api\BridgeController@getVideoPositionById');
    
    Route::get('/getcandidatevideoattempt/{candidate_id}','Api\BridgeController@getCandidateVideoAttempt');
    Route::get('/candidate/download/qid/{qid}/cid/{candidateid}/qindex/{indexid}',  'Api\BridgeController@download');
    Route::get('/candidate/downloadzip/cid/{candidateid}',  'Api\BridgeController@zipVideo');
    Route::post('/addcomments', 'Api\BridgeController@addcomments');
    Route::post('/createnotification', 'Api\BridgeController@createnotification');
    Route::post('/expirevideoaccount', 'Api\BridgeController@expirevideoaccount');
    Route::post('/disconnectinterviewaccount', 'Api\BridgeController@disconnectinterviewaccount');
    Route::post('/autosubscriptioncreate', 'Api\BridgeController@autoSubscriptionCreate');
    Route::get('/candidate/deletevideofromapp/{candidateid}',  'Api\BridgeController@deletevideo');

    Route::post('/recruitcreatenotification', 'Api\BridgeController@recruitcreatenotification');
    Route::post('/disconrecruiternotify', 'Api\BridgeController@disconrecruiternotify');
    
    Route::get('/checkusernamefromappadmin/{email}', 'Api\BridgeController@checkusernamefromappadmin');
    Route::post('/togglestatus', 'Api\BridgeController@togglestatus');
    
    

    
    
});

Route::middleware('auth:api')->get('/employer', function (Request $request) {
    return $request->user();
});

