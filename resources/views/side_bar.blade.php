
<div class="col-md-3 col-md-offset-0">
	<div class="panel panel-default">
		<div class="panel-heading py-2" style="background-color: #44ca75; text-align: center;"><h3><a href="{{ url('my-profile') }}" style="text-decoration: none; color: #FFFFFF;">Dashboard</a></h3></div>

		<div class="panel-body shadow-sm">

			<div class="text-center pt-2">
				@php if ($doc_info->photo) {$photo = $doc_info->photo;} else {$photo="images/doc_male.jpg";} @endphp
				<img src="{{url($photo)}}" width="100" height="100" style="border-radius: 50px; border: 1px solid #22222222;"><br>
				<h5 class="py-2"><b><span style="color: #222;">{{ $doc_info->name }}</span></b></h5>
			</div>

			<div class="sidebar">
				<a class="@php echo (Request::segment(1)=='my-profile')?'active':''  @endphp" href="{{url('my-profile')}}">Profile</a>
				<a class="@php echo (Request::segment(1)=='doctor-admissions')?'active':''  @endphp" href="{{ url('doctor-admissions') }}">Admission Form</a>
				<a class="@php echo (Request::segment(1)=='payment-details' || Request::segment(1)=='doctor-admission-submit')?'active':''  @endphp" href="{{url('payment-details')}}">Pending Courses</a>
				<a class="@php echo (Request::segment(1)=='my-courses')?'active':''  @endphp" href="{{url('my-courses')}}">My Courses</a>
				<a class="@php echo (Request::segment(1)=='schedule')?'active':''  @endphp" href="{{url('schedule')}}">Schedules</a>
				<a class="msi-bold w-100 msi-dark d-flex  py-3 pl-3" href="{{ url('lecture-video') }}"><span>Online Lecture Links</span></a>
				<a class="@php echo (Request::segment(1)=='online-exam')?'active':''  @endphp" href="{{url('online-exam')}}">Online Exam & Results</a>
				<a class="@php echo (Request::segment(1)=='change-password')?'active':''  @endphp" href="{{url('change-password')}}">Change Password</a>
				<a class="py-2 w-100" href="{{ route('logout') }}" onclick="event.preventDefault();
					document.getElementById('logout-form').submit();">
					Logout
				</a>
				<form id="logout-form" action="{{ route('logout') }}" method="POST"
					style="display: none;">
					{{ csrf_field() }}
				</form>
			</div>

		</div>
	</div>
</div>
