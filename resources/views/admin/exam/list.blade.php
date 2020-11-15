@extends('admin.layouts.app')

@section('content')

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i>
            </li>
            <li>{{ $title }}</li>
        </ul>
    </div>

    @if(Session::has('message'))
        <div class="alert alert-success" role="alert">
            <p> {{ Session::get('message') }}</p>
        </div>
    @endif


    <div class="row">
        <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i>{{ $title }}
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover datatable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Exam Name</th>
                            <th>Institute</th>
                            <th>Course</th>
                            <!-- <th>Faculty</th> -->
                            <th>Session/Year</th>
                            <th>MCQ/SBA</th>
                            <th>Total Mark/Time</th>
                            <th>SIF only?</th>
                            <th width="200">Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($exams as $exam)
                        
                            <tr>
                                <td>{{ $exam->id }}</td>
                                <td>{{ $exam->name }}</td>
                                <td>{{ (isset($exam->institute->name))?$exam->institute->name:'' }}</td>
                                <td>{{ (isset($exam->course->name))?$exam->course->name:'' }}</td>
                                <!-- <td>{{ (isset($exam->faculty->name))?$exam->faculty->name:'No Faculty' }}</td> -->
                                <td>
                                @php
                                    $temp_name = \App\Sessions::select('*')->where('id', $exam->session_id)->get();
                                    foreach ($temp_name as $session){
                                       echo $session->name;
                                    }
                                @endphp
                                 {{ $exam->year }}</td>
                                <td>
                                @php
                                    $temp_name = \App\QuestionTypes::select('*')->where('id', $exam->question_type_id)->get();
                                    foreach ($temp_name as $type){
                                       echo "{$type->mcq_number} MCQ / {$type->sba_number} SBA";
                                    }
                                @endphp
                                </td>
                                <td>
                                @php
                                    $temp_name = \App\QuestionTypes::select('*')->where('id', $exam->question_type_id)->get();
                                    foreach ($temp_name as $type){
                                       echo "{$type->full_mark} Mark / {$type->duration} Min";
                                    }
                                @endphp
                                </td>
                                <td>{{ ($exam->sif_only=='Yes')?'Yes':'No' }}</td>
                                <td>

                                    <a href="{{ url('admin/upload-result/'.$exam->id) }}" class="btn btn-xs btn-primary">Upload Result</a>
                                    <a href="{{ url('admin/view-result/'.$exam->id) }}" class="btn btn-xs btn-primary">View Result</a>
                                    @can('Exam Edit')
                                        <a href="{{ url('admin/exam/'.$exam->id.'/edit') }}" class="btn btn-xs btn-primary">Edit</a>
                                    @endcan
                                    @if ($exam->sif_only=='No')
                                    <a  target="_blank" href="{{ url('admin/exam-print/'.$exam->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-print"></i> View</a>
                                    <a  target="_blank" href="{{ url('admin/exam-print-ans/'.$exam->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-print"></i> View+Ans</a>
                                    <a  target="_blank" href="{{ url('admin/exam-print-onlyans/'.$exam->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-print"></i> Only Ans</a>
                                    @endif
                                    @can('Exam Delete')
                                        {!! Form::open(array('route' => array('exam.destroy', $exam->id), 'method' => 'delete','style' => 'display:inline')) !!}
                                        <button onclick="return confirm('Are You Sure ?')" class='btn btn-xs btn-danger' type="submit">Delete</button>
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script type="text/javascript">
        // DO NOT REMOVE : GLOBAL FUNCTIONS!
        $(document).ready(function() {
            $('.datatable').DataTable({
                responsive: true,
                "ordering": false,
                "columnDefs": [
                    { "searchable": false, "targets": 5 },
                    { "orderable": false, "targets": 5 }
                ]
            })
        })
    </script>

@endsection