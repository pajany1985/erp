@extends('employer::layouts.master')
@section('pagetitle','Manage Interviews')

@section('content')

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">

    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">

        <div class="card mb-5 mb-xxl-8 ">
            <div class="card-body pt-9 pb-5 text-center">
                <!--begin::Details-->
                <div >
                   <h3 class="color-D6E">Your Account is Set to Expire on <span>08-03-2022</span></h3>

               </div>
               <div class="text-gray-400 fw-bold">To extend your account beyond your expiration date choose on offering below</div>
               <!--end::Details-->
           </div>
       </div>
       <!--end::Post-->

       <div class="row g-5 g-xxl-8">
        <!--begin::Col-->
        <div class="col-xl-6">
            <!--begin::Feeds Widget 1-->
            <div class="card mb-5 mb-xxl-8">
                <!--begin::Body-->
                <div class="card-body pb-5 text-center">
                    <!--begin::Details-->
                    <div >
                       <h3>Upgrade to Idealtraits</h3>

                   </div>
                   <div class="text-gray-400 fw-bold pb-5">Hiring become very easy for your Firm using Idealtraits.</div>
                   <!--end::Details-->
                   <input type="hidden" name="useremail" id="usermail" value={{ Auth::user()->email }} />
               </div>
               <!--end::Body-->
               <div class="card-footer py-5 text-center" >
                @if(Auth::user()->purchased_idealapp=='1')
                    @if($is_videopackage!='') <!-- comes from employercomposer -->
                    <a href="{{Config::get('constants.APP_IDEALTRAITS_SITE')}}autologintocandidatepage/{{$is_videopackage->business_id}}" target="_blank" class="btn btn-sm btn btn-primary autologidealapp"  data-autologurl="{{Config::get('constants.APP_IDEALTRAITS_SITE')}}autologintocandidatepage/{{$is_videopackage->business_id}}" data-autologid="{{$is_videopackage->business_id}}">View Idealtraits App</a>
                    @else
                    <a href="javascript:void(0);" class="btn btn-sm btn btn-primary"  >Upgrade Package</a>
                    @endif
                @else
                  <a href="javascript:void(0);" class="btn btn-sm btn btn-primary" id="upgradeideal" >Buy for $950</a>
                @endif
               </div>
           </div>

       </div>
       <!--end::Col-->
       <!--begin::Col-->
        <!-- <div class="col-xl-6">
            <div class="card mb-5 mb-xxl-8">
                <div class="card-body pb-5 text-center">
                    <div >
                      <h3>Upgrade to {Package Title} </h3>
                    </div>

                   <div class="text-gray-400 fw-bold pb-5">To extend your account beyond your expiration date choose on offering below</div>
                </div>

               <div class="card-footer py-5 text-center" >
                    <a href="#" class="btn btn-sm btn btn-primary" >Buy for $199</a>
               </div>
           </div>
        </div> -->

</div>
<!--end::Col-->
</div>
</div>
</div>



</div>


@endsection

@section('scripts')
<script src="{{asset('js/employer/settings/upgradepackage.js')}}"></script>
@endsection