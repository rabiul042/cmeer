@extends('layouts.app')
@section('content')
<div class="jumbotron text-center">
  <h1>Registration Form</h1>
</div>
<div class="container">
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover datatable">
                        <thead>
                        <tr>
                            <!-- <th>id</th> -->
                            <!-- <th>doctor_id</th> -->
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
                                <!-- <td>{{ $row->id }}</td> -->
                                <!-- <td>{{ $row->doctor_id }}</td> -->
                                <td>{{ $row->exam }}</td>
                                <td>{{ $row->board }}</td>
                                <td>{{ $row->result }}</td>
                                <td>{{ ($row->passing_year)}}</td>
                                <td>{{ ($row->roll)}}</td>
                                <td>{{ ($row->duration)}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
    <div class="education">
         <h3><a href=""><u>Educational Qualification</u></a></h3>
    </div>
    <form action="{{url('register-third-step-submit')}}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
            <div class="row mx-0">
            <input type="hidden" name="id" value="{{$id}}">
            <div class="col-mod-6 col-lg-3">
                <label>Examination:</label>
            </div>
            <div class="col-mod-6 col-lg-7">
                <select id="selectId" onchange="onChangeSelectBox()" class="form-control" name="exam" required>
                    <option value selected="Selected">Select Exam</option>
                    <option value="Post graduation">Post graduation</option>
                    <option value="Graduation">Graduation</option>
                    <option value="HSC">HSC</option>
                    <option value="SSC">SSC</option>
                </select>
            </div>
            <div class="col-mod-6 col-lg-3">
                <label>Board/Institute:</label>
                @php $medical_colleges->prepend('Select Medical College', ''); @endphp
            </div>
            <div class="col-mod-6 col-lg-7" id="selectBox">
                <select class="form-control" name="board" required>
                    <option value selected="Selected">Select Board</option>
                </select>
            </div>
            <div class="col-mod-6 col-lg-3">
                <label>Result:</label>
            </div>
            <div class="col-mod-6 col-lg-7">
                <input type="text" class="form-control" placeholder="GPA" name="result" required>
            </div>
            <div class="col-mod-6 col-lg-3">
                <label>Passing Year:</label>
            </div>
            <div class="col-mod-6 col-lg-7">
            
            {!! Form::selectRange('year',date('Y'),1980,date('Y') ,['class'=>'form-control p-1 shadow-none','required']) !!}
            </div>
            <div class="col-mod-6 col-lg-3">
                <label>Roll:</label>
            </div>
            <div class="col-mod-6 col-lg-7">
                <input type="number" class="form-control" placeholder="Roll Number" name="roll" required>
            </div>
            <div class="col-mod-6 col-lg-3">
                <label>Duration:</label>
            </div>
            <div class="col-mod-6 col-lg-7">
                <input type="number" class="form-control" placeholder="Duration" name="duration" required>
            </div>
            <input class="save" type="submit" value="Save" name="save">
        </div>
        </div>
    </div>
</form>
</div>
@endsection
@section('js')
<script>
    const selectId = document.getElementById('selectId')
    const selectBox = document.getElementById('selectBox')
    function onChangeSelectBox(){
        if(selectId.value == 'SSC' || selectId.value == 'HSC'){
            selectBox.innerHTML = '<select class="form-control" name="board" required><option value selected="Selected">Select Board</option><option value="Dhaka">Dhaka</option><option value="Rajshahi">Rajshahi</option><option value="Chitagang">Chitagang</option><option value="Barisal">Barisal</option><option value="Comilla">Comilla</option><option value="Dinajpur">Dinajpur</option><option value="Sylhet">Sylhet</option><option value="Rangpur">Rangpur</option><option value="Jessore">Jessore</option><option value="Mymonsingh">Mymonsingh</option><option value="Madrashah">Madrashah</option></select>'
        }
        if(selectId.value == 'Graduation' || selectId.value == 'Post graduation'){
            selectBox.innerHTML = '{!! Form::select('medical_college_id',$medical_colleges, '',['class'=>'form-control select2','required'=>'required', 'id'=>'medical_college_id'])!!}'
        }
    }
</script>
@endsection