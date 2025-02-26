<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\User;
use Carbon\Carbon;
use DB;


class ResultController extends Controller
{

	public function index()
    {
        return view('admin::results.index');
    }


}
?>