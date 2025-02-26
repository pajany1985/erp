<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\Transaction;
use Modules\Admin\Models\Package;
use Modules\Admin\Models\Employer;
use Carbon\Carbon;
use DB;
use Excel;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Modules\Admin\Http\Exports\TransactionExport;



class TransactionController extends Controller
{
	use EncryptDecryptTrait;
    
	public function index()
    {
        $packages = Package::all();
        return view('admin::transactions.index',['packages' => $packages]);
    }

    public function loadtransactions(Request  $request) {
        $transaction = Transaction::orderBy('id', 'desc');

        if(isset($request['employer_search']) && $request['employer_search']){

            $employer_search =  $request['employer_search'];
            $transaction = $transaction->where('employer_id','=',  $employer_search);         
        } 
        if(isset($request['package_search']) && $request['package_search']){

            $package_search =  $request['package_search'];
            $transaction = $transaction->where('package_id','=',  $package_search);         
        }
       if(isset($request['status'])  && $request['status']>='0'){

            $status =  $request['status'];
            $transaction = $transaction->where('status','=',  $status);
            
        } 
        return datatables()->of($transaction->with('Employer','Package')->get())
        ->addColumn('encrypt_id', function ($row) {
            return $this->encryptId($row->employer_id);
        })
        ->toJson();
      

    }

    public function loademployertransactions(Request  $request) {
        $transaction = Transaction::orderBy('id', 'desc');
        if(isset($request['employer_search']) && $request['employer_search']){

            $employer_search =  $request['employer_search'];
            $transaction = $transaction->where('employer_id','=',  $employer_search);         
       } 
       if(isset($request['status']) && $request['status']>='0'){

            $status =  $request['status'];
            $transaction = $transaction->where('status','=',  $status);
            
        } 

        // echo "<pre>"; print_r($request->all()); exit;
        return datatables()->of($transaction->with('Package')->get())
        ->toJson();
      

    }

    public function exporttrans(Request $request){
        return Excel::download(new TransactionExport($request->exportpackage_id,$request->exportstatus), 'Transaction.xlsx');
    }


}
?>