<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\User;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Candidate;
use Modules\Admin\Models\Transaction;
use Modules\Admin\Models\Package;
use Modules\Admin\Models\Position;
use Carbon\Carbon;
use DB;


class DashboardController extends Controller
{

	public function index()
    {
        $employers_count = Employer::get()->count();
        $candidates_count = Candidate::get()->count();
        $packages_count = Package::get()->count();
        $positions_count = Position::get()->count();
        return view('admin::dashboard.index',['employers_count' => $employers_count,'candidates_count' => $candidates_count,'packages_count' => $packages_count,'positions_count' => $positions_count]);
    }

    public function empcandidate(){
        $first_month = Carbon::now()->startOfMonth()->subMonth(5)->format('m');
        $first_year = Carbon::now()->startOfMonth()->subMonth(5)->format('Y');
        $first_monthyear = Carbon::now()->startOfMonth()->subMonth(5)->format('M-Y');

        $second_month = Carbon::now()->startOfMonth()->subMonth(4)->format('m');
        $second_year = Carbon::now()->startOfMonth()->subMonth(4)->format('Y');
        $second_monthyear = Carbon::now()->startOfMonth()->subMonth(4)->format('M-Y');

        $third_month = Carbon::now()->startOfMonth()->subMonth(3)->format('m');
        $third_year = Carbon::now()->startOfMonth()->subMonth(3)->format('Y');
        $third_monthyear = Carbon::now()->startOfMonth()->subMonth(3)->format('M-Y');

        $fourth_month = Carbon::now()->startOfMonth()->subMonth(2)->format('m');
        $fourth_year = Carbon::now()->startOfMonth()->subMonth(2)->format('Y');
        $fourth_monthyear = Carbon::now()->startOfMonth()->subMonth(2)->format('M-Y');

        $fifth_month = Carbon::now()->startOfMonth()->subMonth(1)->format('m');
        $fifth_year = Carbon::now()->startOfMonth()->subMonth(1)->format('Y');
        $fifth_monthyear = Carbon::now()->startOfMonth()->subMonth(1)->format('M-Y');

        $sixth_month = Carbon::now()->startOfMonth()->format('m');
        $sixth_year = Carbon::now()->startOfMonth()->format('Y');
        $sixth_monthyear = Carbon::now()->startOfMonth()->format('M-Y'); 
      
        // Employers count for last 6 months   
        $first_empcount = Employer::whereMonth('created_at', $first_month)->whereYear('created_at', $first_year)->get()->count();
        $second_empcount = Employer::whereMonth('created_at', $second_month)->whereYear('created_at', $second_year)->get()->count();
        $third_empcount = Employer::whereMonth('created_at', $third_month)->whereYear('created_at', $third_year)->get()->count();
        $fourth_empcount = Employer::whereMonth('created_at', $fourth_month)->whereYear('created_at', $fourth_year)->get()->count();
        $fifth_empcount = Employer::whereMonth('created_at', $fifth_month)->whereYear('created_at', $fifth_year)->get()->count();
        $sixth_empcount = Employer::whereMonth('created_at', $sixth_month)->whereYear('created_at', $sixth_year)->get()->count();

        $employers[0]['x'] = $first_monthyear;
        $employers[0]['y']= $first_empcount;

        $employers[1]['x']= $second_monthyear;
        $employers[1]['y']= $second_empcount;

        $employers[2]['x']= $third_monthyear;
        $employers[2]['y']= $third_empcount;

        $employers[3]['x']= $fourth_monthyear;
        $employers[3]['y']= $fourth_empcount;

        $employers[4]['x']= $fifth_monthyear;
        $employers[4]['y']= $fifth_empcount;

        $employers[5]['x']= $sixth_monthyear;
        $employers[5]['y']= $sixth_empcount;
        // Last 6 month end of Employers


        // Candidates count for last 6 months   
        $first_candidatecount = Candidate::whereMonth('created_at', $first_month)->whereYear('created_at', $first_year)->get()->count();
        $second_candidatecount = Candidate::whereMonth('created_at', $second_month)->whereYear('created_at', $second_year)->get()->count();
        $third_candidatecount = Candidate::whereMonth('created_at', $third_month)->whereYear('created_at', $third_year)->get()->count();
        $fourth_candidatecount = Candidate::whereMonth('created_at', $fourth_month)->whereYear('created_at', $fourth_year)->get()->count();
        $fifth_candidatecount = Candidate::whereMonth('created_at', $fifth_month)->whereYear('created_at', $fifth_year)->get()->count();
        $sixth_candidatecount = Candidate::whereMonth('created_at', $sixth_month)->whereYear('created_at', $sixth_year)->get()->count();

        $candidates[0]['x'] = $first_monthyear;
        $candidates[0]['y']= $first_candidatecount;

        $candidates[1]['x']= $second_monthyear;
        $candidates[1]['y']= $second_candidatecount;

        $candidates[2]['x']= $third_monthyear;
        $candidates[2]['y']= $third_candidatecount;

        $candidates[3]['x']= $fourth_monthyear;
        $candidates[3]['y']= $fourth_candidatecount;

        $candidates[4]['x']= $fifth_monthyear;
        $candidates[4]['y']= $fifth_candidatecount;

        $candidates[5]['x']= $sixth_monthyear;
        $candidates[5]['y']= $sixth_candidatecount;
        // Last 6 month end of Candidates
      
        // return $employers;
        return response()->json(['success' => 'Successfully', 'employers' => $employers, 'candidates' => $candidates]);
    }

    public function transactionschart(){
        $first_month = Carbon::now()->startOfMonth()->subMonth(5)->format('m');
        $first_year = Carbon::now()->startOfMonth()->subMonth(5)->format('Y');
        $first_monthyear = Carbon::now()->startOfMonth()->subMonth(5)->format('M-Y');

        $second_month = Carbon::now()->startOfMonth()->subMonth(4)->format('m');
        $second_year = Carbon::now()->startOfMonth()->subMonth(4)->format('Y');
        $second_monthyear = Carbon::now()->startOfMonth()->subMonth(4)->format('M-Y');

        $third_month = Carbon::now()->startOfMonth()->subMonth(3)->format('m');
        $third_year = Carbon::now()->startOfMonth()->subMonth(3)->format('Y');
        $third_monthyear = Carbon::now()->startOfMonth()->subMonth(3)->format('M-Y');

        $fourth_month = Carbon::now()->startOfMonth()->subMonth(2)->format('m');
        $fourth_year = Carbon::now()->startOfMonth()->subMonth(2)->format('Y');
        $fourth_monthyear = Carbon::now()->startOfMonth()->subMonth(2)->format('M-Y');

        $fifth_month = Carbon::now()->startOfMonth()->subMonth(1)->format('m');
        $fifth_year = Carbon::now()->startOfMonth()->subMonth(1)->format('Y');
        $fifth_monthyear = Carbon::now()->startOfMonth()->subMonth(1)->format('M-Y');

        $sixth_month = Carbon::now()->startOfMonth()->format('m');
        $sixth_year = Carbon::now()->startOfMonth()->format('Y');
        $sixth_monthyear = Carbon::now()->startOfMonth()->format('M-Y'); 
      
        // Transaction Amount for last 6 months   
        $first_transAmount = Transaction::whereMonth('created_at', $first_month)->whereYear('created_at', $first_year)->sum('amount');
        $second_transAmount = Transaction::whereMonth('created_at', $second_month)->whereYear('created_at', $second_year)->sum('amount');
        $third_transAmount = Transaction::whereMonth('created_at', $third_month)->whereYear('created_at', $third_year)->sum('amount');
        $fourth_transAmount = Transaction::whereMonth('created_at', $fourth_month)->whereYear('created_at', $fourth_year)->sum('amount');
        $fifth_transAmount = Transaction::whereMonth('created_at', $fifth_month)->whereYear('created_at', $fifth_year)->sum('amount');
        $sixth_transAmount = Transaction::whereMonth('created_at', $sixth_month)->whereYear('created_at', $sixth_year)->sum('amount');

        $transaction[0]['x'] = $first_monthyear;
        $transaction[0]['y']= $first_transAmount;

        $transaction[1]['x']= $second_monthyear;
        $transaction[1]['y']= $second_transAmount;

        $transaction[2]['x']= $third_monthyear;
        $transaction[2]['y']= $third_transAmount;

        $transaction[3]['x']= $fourth_monthyear;
        $transaction[3]['y']= $fourth_transAmount;

        $transaction[4]['x']= $fifth_monthyear;
        $transaction[4]['y']= $fifth_transAmount;

        $transaction[5]['x']= $sixth_monthyear;
        $transaction[5]['y']= $sixth_transAmount;
        // Last 6 month end of Transactions

        return response()->json(['success' => 'Successfully', 'transaction' => $transaction]);

    }

     public function videocheck(){
         return view('admin::dashboard.videocheck');
     }

}
?>