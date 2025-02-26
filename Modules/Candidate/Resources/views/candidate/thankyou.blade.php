<!DOCTYPE html>
<!--
Author: Idealtraits
Product Name: Idealtraits video Tool for Interview
Website: http://www.Idealtraits.com
Contact: support@Idealtraits.com
Follow: www.twitter.com/Idealtraits
Dribbble: www.dribbble.com/Idealtraits
Like: www.facebook.com/Idealtraits
-->
<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<title>Idealtraits |  @yield('pagetitle')</title>
		<meta charset="utf-8" />
		<meta name="description" content="Idealtraits video Tool for Interview" />
		<meta name="keywords" content="Idealtraits, ideal, interview, assessment, job, video assessment" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Idealtraits video Tool for Interview" />
		<meta property="og:url" content="https://idealtraits.com" />
		<meta property="og:site_name" content="Idealtraits | Interview" />
		<link rel="canonical" href="https://idealtraits.com" />
		<link rel="shortcut icon" href="{{asset('logo/favicon.ico')}}" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		<link href="{{asset('css/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Page Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{asset('css/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('css/cropper.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="auth-bg">
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root text-center">
			<!--begin::Authentication - 404 Page-->
			<div class="d-flex flex-column flex-center flex-column-fluid p-10">
				<!--begin::Illustration-->
				<h1 class="mw-100 mb-10  fs-1 fw-bolder mb-5" >Congratulations!</h1>
				<!--end::Illustration-->
				<!--begin::Message-->
				<div class="fw-bold fs-3 text-muted mb-15 ">Your videos are currently being processed.  
						<br>We will notify you as soon as your answers are visible to <span class="fw-bolder text-dark">{{ucfirst($candidate->employer->first_name)}}</span> at <span class="fw-bolder text-dark">{{ucfirst($candidate->employer->company_name)}}</span> </div>
                <i class=" text-muted fs-7">Your session will end in <span id="timer">5</span>….</i>
				<input type="hidden" value="{{$candidate->id}}" id="candidate_id" name="candidate_id">
				<!--end::Message-->
				<!--begin::Link-->
				<!-- <a href="../../demo1/dist/index.html" class="btn btn-primary">Return Home</a> -->
				<!--end::Link-->
			</div>
			<!--end::Authentication - 404 Page-->
		</div>
		<!--end::Root-->
		<!--end::Main-->
		<!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
        <script src="{{asset('js/plugins.bundle.js')}}"></script>
		<script src="{{asset('js/scripts.bundle.js')}}"></script>
        <script type="text/javascript">
            
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $(document).ready(function(){

				savecandidatelog('thankyoupage');
				var counter = 5;
				var interval = setInterval(function() {
					counter--;
					// Display 'counter' wherever you want to display it.
					if (counter <= 0) {
							clearInterval(interval);  
						window.location.replace('/pid/logout');
					}else{
						$('#timer').text(counter);
					}
				}, 1000);


				
				
			});

			function savecandidatelog(action){
				var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
				var height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
				var screenresolution = width+' x '+height;
				var currentURL = window.location.href;
				var clientIP ='';
				var candidate_id = $('#candidate_id').val();
				fetch('https://api.ipify.org/?format=json')
				.then(response => response.json())
				.then(data => {
				clientIP = data.ip;
				console.log("Client IP Address: " + clientIP);
					$.ajax({
						url:"/savecandidatelog",
						method:"post",
						data: { "screenresolution": screenresolution,action,currentURL,candidate_id,clientIP},
						success:function(data)
						{
							if(data.success == '1'){
								console.log('saved');
							}else{
								console.log('not saved');
							}
						}
					});
				});
				
			}
        </script>
		<!--end::Global Javascript Bundle-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>