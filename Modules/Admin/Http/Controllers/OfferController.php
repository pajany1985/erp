<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\User;
use Carbon\Carbon;
use DB;
use Modules\Admin\Models\Package;
use Modules\Admin\Models\Offer;
use Modules\Admin\Models\Employer;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Modules\Admin\Http\Traits\EmailTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Excel;
use Hash;
use Modules\Admin\Http\Exports\OfferExport;



class OfferController extends Controller
{

    use EncryptDecryptTrait,EmailTrait;

    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

	public function index()
    {
        $packages = Package::where('status','1')->orderBy('id', 'desc')->get();
        return view('admin::offer.index',['packages' => $packages]);
    }

    public function create() {
		
        $packages = Package::where('status','1')->get();
        if($packages->count() >0){
            return view('admin::offer.addedit',['packages' => $packages]);
        }
				

	}

    public function store(Request  $request) {
        $active_periods = explode('to',$request->activefrom_date);
        $from_date = trim($active_periods[0]);
        $to_date = trim($active_periods[1]);
       
        $this->offer->offername=trim($request->offername);
        $this->offer->description=trim($request->offer_description);
        $this->offer->price=trim($request->offer_amount);
        $this->offer->status=trim($request->status);
        $this->offer->extent_expiry_days=trim($request->expiryindays);
        $this->offer->from_date = $from_date;
        $this->offer->to_date = $to_date;
        $this->offer->package_id=trim($request->package);
        $this->offer->save();
        return redirect('admin/offers')->with('success', 'Offer Created Successfully');
    }


    public function loadoffers(Request  $request) {
        $offer = Offer::with('package')->orderBy('id', 'desc');
        if(isset($request['query']['generalSearch'])){

            $search =  $request['query']['generalSearch'];
            $offer = $offer->where(function ($query)  use ($search ) { $query->where('offername','like', '%' . $search . '%');
            //  ->orWhere('email' , 'like', '%' . $search . '%');
             });         
        } 
        if(isset($request['status'])  && $request['status']>='0'){
            $search =  $request['status'];
            $offer = $offer->where('status','=',  $search);
            
        }
        if(isset($request['package_id'])  && $request['package_id']){

            $offer = $offer->where('package_id','=',trim($request['package_id']));
        }  
        return datatables()->of($offer->get())
        ->addColumn('actions', function ($row) {

            $encryption = $this->encryptId($row->id);
            return view('admin::offer.actions',['offer'=>$row,'offer_id' => $encryption, 'auth_userid' => Auth::user()->id ]);
        })->toJson();


    }


    public function edit($id) {

        $id=$this->decryptId($id);
        $offer = $this->offer::with('package')->findOrFail($id);
        $packages = Package::where('status','1')->get();
        return view('admin::offer.addedit',['offer' => $offer,'packages' => $packages]);
    }

    public function update(Request  $request,$id) {
        $offer = $this->offer::find($id);
        
        $active_periods = explode('to',$request->activefrom_date);
        $from_date = trim($active_periods[0]);
        $to_date = trim($active_periods[1]);

        $offer->offername = trim($request->offername);
        $offer->description = trim($request->offer_description);
        $offer->status =  $request->status;
        $offer->price =  trim($request->offer_amount);
        $offer->extent_expiry_days = trim($request->expiryindays);
        $offer->from_date =  $from_date;
        $offer->to_date = $to_date;
        $offer->package_id = trim($request->package);

        $offer->save();

        return redirect('admin/offers')->with('success', 'Offer Updated Successfully');
        //return Redirect::back()->with('success','Package Updated successfully');

    }

    public function destroy($id) {

        $id = $this->decryptId($id);
        $this->offer->destroy($id);
        return response()->json(['success' => 'Deleted Successfully', 'code' => '1']);
   
    }

    public function massdelete(Request  $request) {

            $this->offer->destroy($request->input('id'));
            
            return response()
            ->json(['success' => 'Deleted Successfully', 'code' => '1']);
    

    }

    public function exportoffers(Request  $request)
    {
        return Excel::download(new OfferExport($request->exportpackage,$request->exportstatus), 'Offer.xlsx'); 
    }
}
?>