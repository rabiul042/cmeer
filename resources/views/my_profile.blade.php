@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('side_bar')
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>My Profile</h3>
                </div>

                <div class="panel-body shadow-sm">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="col">
                        @php if ($doc_info->photo) {$photo = $doc_info->photo;} else {$photo="images/doc_male.jpg";}
                        @endphp
                        <img src="{{url($photo)}}" width="100" height="100">
                    </div>
                    <div class="col">
                        <h4 class="py-2"><b>{{ $doc_info->name }}</b></h4>
                        <h5> Father : {{ $doc_info->father_name }}</h5>
                        <h5> Mother : {{ $doc_info->mother_name }}</h5>
                        <h5> Medical College :
                            {{ (isset($doc_info->medicalcolleges->name))?$doc_info->medicalcolleges->name:'' }}</h5>
                    </div>

                    <div class="col">
                        <h5> BMDC No. : {{ $doc_info->bmdc_no }}</h5>
                        <h5> Mobile : {{ $doc_info->mobile_number }}</h5>
                        <h5> Email : {{ $doc_info->email }}</h5>
                    </div>

                    <div class="col">
                        <hr>
                    </div>

                    <div class="col">
                        <h5> Gender : {{ $doc_info->gender }}</h5>
                        <h5> Date of Birth : {{ $doc_info->date_of_birth }}</h5>
                        <h5> NID : {{ $doc_info->nid }}</h5>
                    </div>

                    <div class="col">
                        <h5> Employment Status : {{ $doc_info->job_description }}</h5>
                    </div>

                    <!-- <div class="col">
                        <hr>
                    </div>

                    <div class="col">

                        <h5> Passport : {{ $doc_info->passport }}</h5>
                        <h5> Job Description : {{ $doc_info->job_description }}</h5>
                    </div> -->

                    <div class="col-md-12 col-md-offset-0" style="">
                        <hr>
                    </div>

                    <div class="col">
                        <div class="address">
                            <h4><u> Present Address </u></h4>
                        </div>
                        <h5>Address : {{ $doc_info->present_address }}</h5>
                        <h5> Upazila :
                            {{ (isset($doc_info->present_upazila->name))? $doc_info->present_upazila->name : '' }}</h5>
                        <h5> District :
                            {{ (isset($doc_info->present_district->name))? $doc_info->present_district->name : '' }}
                        </h5>
                        <h5> Division :
                            {{ (isset($doc_info->present_division->name))? $doc_info->present_division->name : '' }}
                        </h5>
                    </div>

                    <div class="col">
                        <div class="address">
                            <h4><u> Permanent Address </u></h4>
                        </div>
                        <h5>Address : {{ $doc_info->permanent_address }}</h5>
                        <h5> Upazila :
                            {{ (isset($doc_info->permanent_thana->name))? $doc_info->permanent_thana->name : '' }}</h5>
                        <h5> District :
                            {{ (isset($doc_info->permanent_district->name))? $doc_info->permanent_district->name : '' }}
                        </h5>
                        <h5> Division :
                            {{ (isset($doc_info->permanent_division->name))? $doc_info->permanent_division->name : '' }}
                        </h5>
                    </div>

                    <div class="col">
                        <hr>
                    </div>



                    <div class="portlet-body">
                        <div class="address">
                            <h4>Educational Qualification</h4>
                        </div>
                        <table class="table table-striped table-bordered table-hover datatable">
                            <thead>
                                <tr>
                                    <th>Exam</th>
                                    <th>Board</th>
                                    <th>Result </th>
                                    <th>Passing year</th>
                                    <th>Roll</th>
                                    <th>Duration</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($doctors_education as $row)
                                <tr>
                                    <td>{{ $row->exam }}</td>
                                    @if($row->exam == 'SSC' || $row->exam =='HSC' || $row->exam== 'Post-Graduation')
                                        <td>{{ $row->board }}</td>
                                    
                                    @else
                                        <td>{{ (isset($row->medical_college->name))?$row->medical_college->name:'' }}</td>
                                    
                                    @endif
                                    <td>{{ $row->result }}</td>
                                    <td>{{ ($row->passing_year)}}</td>
                                    <td>{{ ($row->roll)}}</td>
                                    <td>{{ ($row->duration)}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>











                    <div class="col">
                        <a href="{{ url('my-profile/edit/'.$doc_info->id) }}" class="btn btn-xs btn-primary">Edit
                            Profile</a>
                        {{--<a href="#" class="btn btn-xs btn-primary">Enter Institute Roll</a>--}}
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection