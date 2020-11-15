@extends('layouts.app')

@section('content')
<style>

.page-breadcrumb {
  display: inline-block;
  float: left;
  padding: 8px;
  margin: 0;
  list-style: none;
}
.page-breadcrumb > li {
  display: inline-block;
}
.page-breadcrumb > li > a,
.page-breadcrumb > li > span {
  color: #666;
  font-size: 14px;
  text-shadow: none;
}
.page-breadcrumb > li > i {
  color: #999;
  font-size: 14px;
  text-shadow: none;
}
.page-breadcrumb > li > i[class^="icon-"],
.page-breadcrumb > li > i[class*="icon-"] {
  color: gray;
}

</style>

<div class="container">


    <div class="row">

        {{--@include('side_bar')--}}

        <div class="col-md-9 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#7fc9f6; color: #FFFFFF;"><h3>{{ '' }}</h3></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif


                        <div class="col-md-12">
                            <div class="portlet">
                                <div class="portlet-body">
                                  <b><ul class="page-breadcrumb">
                                      <li>
                                          <i class="fa fa-home"></i> <a href="{{ url('/my-profile') }}"> Home</a></i>
                                      </li>
                                      <li> <i class="fa fa-angle-right"></i> <a href="/lecture-video">Lecture Video</a></li>
                                      <li> <i class="fa fa-angle-right"></i> {{ '' }} </li>
                                  </ul></b>
                                    @if(Request::segment(1)=='doctor-course-lecture-video')
                                        @if(isset($lecture_video_batch)) 
                                        <div class="row">

                                            <div class="col-md-12">
                                                                                    
                                                @foreach($lecture_video_batch as $lecture_video)
                                                    <div class="col-md-4">
                                                        <h4><a href="{{ url( 'lecture-video-details/'.$lecture_video->id ) }}" style="font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;font-weight:bold;color:indigo;">{{ $lecture_video->name }}</a></h4>
                                                        <!-- <a href="{{ url( 'lecture-video-details/'.$lecture_video->id ) }}">Continue...</a> -->
                                                    </div>
                                                @endforeach
                                                
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">                                        
                                                <div class="text-center">
                                                    {{ $lecture_video_batch->links() }}
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @elseif(Request::segment(1)=='lecture-video')
                                    <div class="row">
                                        <div class="col-md-12">
                                        <div class="col-md-12" style="color:green;font-size:19px;font-weight:bold;">Click / Tap below to get videos: </div>                                                                                
                                        @foreach($doctor_courses as $doctor_course)
                                            <div class="col-md-4">
                                                <h4><a class="@php echo (Request::segment(1)=='doctor-course-lecture-video' && Request::segment(2)==$doctor_course->id )?'active':''  @endphp" href="{{url('doctor-course-lecture-video/'.$doctor_course->id)}}">{{ $doctor_course->course->name.' ('.$doctor_course->reg_no.')'.' - '.$doctor_course->batch->name }}</a></h4>
                                            </div>
                                        @endforeach                                            
                                        </div>
                                    </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>

        <div class="col-md-3  col-md-offset-0">
        <div class="panel panel-default">
		<div class="panel-heading" style="background-color: #7fc9f6; text-align: center;"><h3><a href="#" style="text-decoration: none; color: #FFFFFF;">{{ '' }} Courses </a></h3></div>

		<div class="panel-body">
        <div class="sidebar">
            @foreach($doctor_courses as $doctor_course)
                <!-- <a class="@php echo (Request::segment(1)=='lecture-video' && Request::segment(2)==$doctor_course->course->id && Request::segment(3)==$doctor_course->batch->id )?'active':''  @endphp" href="{{url('lecture-video/'.$doctor_course->course->id.'/'.$doctor_course->batch->id)}}">{{ $doctor_course->course->name.' ('.$doctor_course->reg_no.')' }}</a> -->
                <a class="@php echo (Request::segment(1)=='doctor-course-lecture-video' && Request::segment(2)==$doctor_course->id )?'active':''  @endphp" href="{{url('doctor-course-lecture-video/'.$doctor_course->id)}}">{{ $doctor_course->course->name.' ('.$doctor_course->reg_no.')' }}</a>				
            @endforeach
        </div>
        </div>
		</div>

        </div>

    </div>


</div>
@endsection
