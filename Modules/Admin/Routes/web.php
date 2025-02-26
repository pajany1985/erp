<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\LoginController;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
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


//WebSocketsRouter::webSocket('/example', \App\WebSocket\ExampleWebSocketHandler::class);


Route::prefix('admin')->group(function() {
   
    Route::get('/login', ['as' => 'admin.login', 'uses' => 'LoginController@index'])->middleware('guestadmin:admin');
    Route::get('/logout', ['as' => 'admin.logout', 'uses' => 'LoginController@logout']);
    Route::post('/validatelogin', ['as' => 'admin.validatelogin', 'uses' => 'LoginController@validatelogin']);
    Route::post('/employers/checkemailexist',  'EmployerController@validateemail');
    Route::post('/employers/emailpresent',  'EmployerController@emailPresentNot'); 
    Route::post('/employers/dynamicstates', 'EmployerController@dynamicstates');
    Route::post('/candidates/sendinvite', 'CandidateController@sendinvite');


    Route::get('/videocheck', ['as' => 'admin.videocheck', 'uses' => 'DashboardController@videocheck']);
    Route::post('/save-stream', ['as' => 'admin.save-stream', 'uses' => 'VideoController@save-stream']);

    Route::group(['middleware' => 'adminauth:admin'], function () {

        //  Dashboard
        Route::get('/', ['as' => 'admin.home', 'uses' => 'DashboardController@index']);
        Route::get('/dashboard', ['as' => 'admin.dashboard', 'uses' => 'DashboardController@index']);
        Route::get('/dashboard/empcandidate', ['as' => 'admin.empcandidate', 'uses' => 'DashboardController@empcandidate']);
        Route::get('/dashboard/transactionschart', ['as' => 'admin.transactionschart', 'uses' => 'DashboardController@transactionschart']);

        
        // Manage Users
        Route::resource('users', 'UserController');
        Route::get('/loadusers', ['as' => 'admin.loadusers', 'uses' => 'UserController@loadusers']);
        Route::post('/emailvalidate',  'UserController@validateemail'); 
        Route::post('/usernamevalidate',  'UserController@validateusername'); 
        Route::post('/export-users',  'UserController@exportusers')->name('export-users');
        Route::post('/users/usermassdelete', 'UserController@massdelete');
        Route::post('/users/userupdate', 'UserController@updatestatus');

        // Manage Packages
        Route::resource('packages', 'PackageController');
        Route::get('/loadpackages',['as' => 'admin.loadpackages','uses' => 'PackageController@loadpackages']);
         Route::post('/export-packages','PackageController@exportpackages')->name('export-packages');
        Route::post('/packages/packagemassdelete', 'PackageController@massdelete');
        // Manage Roles
        Route::resource('roles', 'RoleController');
        Route::get('/roles', 'RoleController@index');
        

        // Manage Employers
        Route::resource('employers', 'EmployerController');
        Route::get('/loademployers', ['as' => 'admin.loademployers', 'uses' => 'EmployerController@loademployers']);
        Route::post('/export-employers',  'EmployerController@exportemployers')->name('export-employers');
        Route::post('/employers/employermassdelete', 'EmployerController@massdelete');
        Route::post('/employers/employerupdate', 'EmployerController@updatestatus');
        Route::post('/employers/employerupdatepayment', 'EmployerController@updatepaymentstatus');
        Route::post('/employers/empfiltersession', 'EmployerController@empfiltersession');
        Route::post('/employers/empresetsession', 'EmployerController@empresetsession');

        

        Route::post('/employer/empnotes','EmployerController@empnotes');
        Route::get('/employer/commentlist/{employer}', ['uses' => 'EmployerController@commentlist']);

        // Manage Subemployers
        Route::resource('subemployers', 'SubEmployerController');
        Route::get('/loadsubemployers', ['as' => 'admin.loadsubemployers', 'uses' => 'SubEmployerController@loadsubemployers']);
        Route::post('/export-subemployers',  'SubEmployerController@exportsubemployers')->name('export-subemployers');
        Route::post('/subemployers/subemployermassdelete', 'SubEmployerController@massdelete');
        Route::post('/subemployers/subemployerupdate', 'SubEmployerController@updatestatus');
        Route::post('/subemployers/masterempdetails', 'SubEmployerController@masterempdetails');

        // Manage Positions
        Route::resource('positions', 'PositionController');
        Route::get('/loadpositions',['as' => 'admin.loadpositions','uses' => 'PositionController@loadpositions']);
        Route::post('/positions/checkempallowed', 'PositionController@checkempallowed');
        Route::post('/positions/checkmaxattempts', 'PositionController@checkmaxattempts');
        Route::post('/positions/checkmaxminutes', 'PositionController@checkmaxminutes');
        Route::post('/positions/positionupdate', 'PositionController@updatestatus');
        Route::post('/positions/positionmassdelete', 'PositionController@massdelete');
        Route::get('/positions/{positionid}/questions', 'PositionController@questionIndex');
        Route::get('/positions/{positionid}/questions/create', 'PositionController@questionscreate');
        Route::post('/positions/{positionid}/questions/store', 'PositionController@questionsstore');
        Route::post('/positions/qstndelete/{qstnid}', 'PositionController@questiondelete');
        Route::post('/positions/questionmassdelete', 'PositionController@questionmassdelete');
        Route::get('/positions/qstnedit/{qstnid}/edit', 'PositionController@qstnedit');
        Route::post('/positions/qstnupdate/{qstnid}', 'PositionController@questionupdate');


        Route::get('/loadquestions',['as' => 'admin.loadquestions','uses' => 'PositionController@loadquestions']);
        


        // Manage Candidates
        Route::resource('candidates', 'CandidateController');
        Route::get('/loadcandidates', ['as' => 'admin.loadcandidates', 'uses' => 'CandidateController@loadcandidates']);
        Route::get('/loademployercandidates', ['as' => 'admin.loademployercandidates', 'uses' => 'CandidateController@loademployercandidates']);
        Route::post('/candidates/employerposition', 'CandidateController@employerposition');
        Route::post('/candidates/emailvalidate',  'CandidateController@validateemail'); 
        Route::post('/candidates/positionvalidate',  'CandidateController@positionvalidate');
        Route::post('/candidates/candidatemassdelete', 'CandidateController@massdelete');
        Route::post('/candidates/candidateupdate', 'CandidateController@updatestatus');
        Route::post('/export-candidates',  'CandidateController@exportcandidates')->name('export-candidates');


        // Manage Interview Results
        Route::resource('results', 'ResultController');

        // Manage Transactions
        Route::resource('transactions', 'TransactionController');
        Route::post('/export-trans',  'TransactionController@exporttrans')->name('export-trans');

        Route::get('/loadtransactions', ['as' => 'admin.loadtransaction', 'uses' => 'TransactionController@loadtransactions']);
        Route::get('/loademployertransactions', ['as' => 'admin.loademployertransactions', 'uses' => 'TransactionController@loademployertransactions']);
        // Manage Mail content
        Route::resource('mailcontent', 'MailcontentController');
        Route::get('/loadmailcontents', ['as' => 'admin.loadmailcontent', 'uses' => 'MailcontentController@loadmailcontents']);

        // Manage Mail content
        Route::resource('cmspage', 'CmspageController');
        Route::get('/loadcmspages', ['as' => 'admin.loadcmspage', 'uses' => 'CmspageController@loadcmspages']);

        // Manage Question Tempalte
        Route::resource('questiontemp', 'QuestionTemplateController');
        Route::get('/loadquestiontemp', ['as' => 'admin.loadquestiontemp', 'uses' => 'QuestionTemplateController@loadquestiontemp']);
        Route::post('/questiontemp/questionmassdelete', 'QuestionTemplateController@massdelete');

        // Manage Interview Offers
        Route::resource('offers', 'OfferController');
        Route::get('/loadoffers',['as' => 'admin.loadoffers','uses' => 'OfferController@loadoffers']);
        Route::post('/export-offers','OfferController@exportoffers')->name('export-offers');
        Route::post('/offers/offermassdelete', 'OfferController@massdelete');

    });
});
