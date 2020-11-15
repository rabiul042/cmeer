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
                                      <li> <i class="fa fa-angle-right"></i> <a href="/online-exam">Online Exam</a></li>
                                      <li> <i class="fa fa-angle-right"></i> {{ '' }} </li>
                                  </ul></b>
                                    @if(Request::segment(1)=='doctor-course-online-exam')
                                        @if(isset($online_exam_batch)) 
                                        <div class="row">

                                            
                                            <div class="col-md-12">
                                                <div class="portlet">
                                                    <div class="portlet-body">
                                                        <table class="table table-striped table-bordered table-hover datatable">
                                                            <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>Reg. No.</th>
                                                                <th><b>Online Exam Links</b></th>
                                                                <th><b>Online Results & Answer Details</b></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            
                                                                @foreach($online_exam_batch as $k=>$link)
                                                                
                                                                <tr>
                                                                <td >{{ ++$k }}</td>
                                                                <td >{{ $doctor_course->reg_no }}</td>
                                                                <td ><a href="{{ 'https://banglamedexam.com/user-login-sif?'.'name='.$doctor_course->doctor->name.'&email='.$doctor_course->reg_no.'&bmdc='.$doctor_course->doctor->bmdc_no.'&phone='.$doctor_course->doctor->mobile_number.'&exam_comm_code='.$link->exam_comm_code.'&topic_code='."0" }}" target="_blank" class="btn btn-xs btn-primary">{{ $link->exam_comm_code }}</a></td>
                                                                <td >
                                                                        <a href="{{ "https://banglamedexam.com/history_sif.php?reg_no=".$doctor_course->reg_no }}" target="_blank" class="btn btn-xs btn-success">Online Results & Answer Details</a>
                                                                </td>    
                                                                    
                                                                </tr>
                                                                
                                                                @endforeach
                                                            
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">                                        
                                                <div class="text-center">
                                                    {{ $online_exam_batch->links() }}
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @elseif(Request::segment(1)=='online-exam')
                                    <div class="row">
                                        <div class="col-md-12">
                                        <div class="col-md-12" style="color:green;font-size:19px;font-weight:bold;">Click / Tap below to get online exam links: </div>                                                                                
                                        @foreach($doctor_courses as $doctor_course)
                                            <div class="col-md-4">
                                                <h4><a class="@php echo (Request::segment(1)=='doctor-course-online-exam' && Request::segment(2)==$doctor_course->id )?'active':''  @endphp" href="{{url('doctor-course-online-exam/'.$doctor_course->id)}}">{{ $doctor_course->course->name.' ('.$doctor_course->reg_no.')'.' - '.$doctor_course->batch->name }}</a></h4>
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
                <!-- <a class="@php echo (Request::segment(1)=='online-exam' && Request::segment(2)==$doctor_course->course->id && Request::segment(3)==$doctor_course->batch->id )?'active':''  @endphp" href="{{url('online-exam/'.$doctor_course->course->id.'/'.$doctor_course->batch->id)}}">{{ $doctor_course->course->name.' ('.$doctor_course->reg_no.')' }}</a> -->
                <a class="@php echo (Request::segment(1)=='doctor-course-online-exam' && Request::segment(2)==$doctor_course->id )?'active':''  @endphp" href="{{url('doctor-course-online-exam/'.$doctor_course->id)}}">{{ $doctor_course->course->name.' ('.$doctor_course->reg_no.')' }}</a>				
            @endforeach
        </div>
        </div>
		</div>

        </div>

    </div>


</div>
@endsection
