@extends('layouts.app')

@section('content')
<div class="container">


    <div class="row">

        @include('side_bar')

        <div class="col-md-9 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#7fc9f6; color: #FFFFFF;">
                    <h3>Edit Profile</h3>
                </div>

                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="col-md-12">

                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            {{--{!! Form::open(['url'=>['update-password', $doc_info->id],'method'=>'PUT','files'=>true,'class'=>'form-horizontal']) !!}--}}
                            {!!
                            Form::open(['url'=>['update-profile'],'method'=>'post','files'=>true,'class'=>'form-horizontal'])
                            !!}


                            <div class="form-body">

                                <div class="form-group">

                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            Doctor Name <br>
                                            <input type="text" name="doc_name" value="{{ $doc_info->name }}"
                                                class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <br>BMDC No. : <br>
                                            <input type="text" name="bmdc_no" value="{{ $doc_info->bmdc_no }}"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <br>Medical College : <br>

                                            {!! Form::select('medical_college_id',$medical_colleges,
                                            $doc_info->medical_college_id ? $doc_info->medical_college_id : ''
                                            ,['class'=>'form-select select2', 'required'=>'required']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <br>Father's Name : <br>
                                            <input type="text" name="father_name" value="{{ $doc_info->father_name }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <br>Mother's Name : <br>
                                            <input type="text" name="mother_name" value="{{ $doc_info->mother_name }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <br>Mobile <br>
                                            <input type="number" name="mobile_number"
                                                value="{{ $doc_info->mobile_number }}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <br>Email : <br>
                                            <input type="email" name="email" value="{{ $doc_info->email }}"
                                                class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <br>Gender : <br>
                                            <input type="text" name="gender" value="{{ $doc_info->gender }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <br>Date of Birth <br>
                                            <input type="date" name="date_of_birth"
                                                value="{{ $doc_info->date_of_birth }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <br>Employment Status : <br>
                                            <input type="text" name="job_description"
                                                value="{{ $doc_info->job_description }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <br>NID <br>
                                            <input type="number" name="nid" value="{{ $doc_info->nid }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <div class="input-icon right">
                                            <br>Passport : <br>
                                            <input type="text" name="passport" value="{{ $doc_info->passport }}"
                                                class="form-control">
                                        </div>
                                    </div> -->

                                </div>

                                <div class="form-group">
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <br>Password<br>
                                            <input type="text" name="main_password"
                                                value="{{ $doc_info->main_password }}" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <br>Change Profile Picture<br>
                                            <input type="file" name="image" class="profile">
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-primary" style="border-color: #eee; ">
                                    <div class="panel-heading"
                                        style="background-color: #eee; color: black; border-color: #eee; ">Present
                                        Address</div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <label class="col-md-1 control-label">Division</label>
                                                <div class="col-md-12">
                                                    @php $divisions->prepend('Select Division', ''); @endphp
                                                    {!! Form::select('present_division_id',$divisions,
                                                    $doc_info->present_division_id ? $doc_info->present_division_id : ''
                                                    ,['class'=>'form-control']) !!}<i></i>
                                                </div>

                                                <div class="present_district">
                                                {!! Form::select('present_district_id',$present_districts, $doc_info->present_district_id?$doc_info->present_district_id:'' ,['class'=>'form-control']) !!}<i></i>
                                                </div>

                                                <div class="present_upazila">
                                                {!! Form::select('present_upazila_id',$present_upazilas, $doc_info->present_upazila_id?$doc_info->present_upazila_id:'' ,['class'=>'form-control']) !!}<i></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-1 control-label">Address</label>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <textarea class="form-control" rows="3"
                                                        name="present_address">{{ $doc_info->present_address ? $doc_info->present_address :'' }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>




                                <div class="panel panel-primary" style="border-color: #eee; ">
                                    <div class="panel-heading"
                                        style="background-color: #eee; color: black; border-color: #eee; ">Permanent
                                        Address</div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <label class="col-md-1 control-label">Division</label>
                                                <div class="col-md-12">
                                                    @php $divisions->prepend('Select Division', ''); @endphp
                                                    {!! Form::select('permanent_division_id',$divisions,
                                                    $doc_info->permanent_division_id ? $doc_info->permanent_division_id
                                                    : ''
                                                    ,['class'=>'form-control']) !!}<i></i>
                                                </div>

                                                <div class="permanent_district">
                                                {!! Form::select('permanent_district_id',$permanent_districts, $doc_info->permanent_district_id?$doc_info->permanent_district_id:'' ,['class'=>'form-control']) !!}<i></i>

                                                </div>

                                                <div class="permanent_upazila">
                                                {!! Form::select('permanent_upazila_id',$permanent_upazilas, $doc_info->permanent_upazila_id?$doc_info->permanent_upazila_id:'' ,['class'=>'form-control']) !!}<i></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-1 control-label">Address</label>
                                            <div class="col-md-4">
                                                <div class="input-icon right">
                                                    <textarea class="form-control" rows="3"
                                                        name="present_address">{{ $doc_info->permanent_address ? $doc_info->permanent_address :'' }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="panel-heading"
                                    style="background-color: #eee; color: black; border-color: #eee; ">Educational
                                    Qualification</div>



                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row mx-0">
                                            <div class="exam">
                                                <h4>SSC/Equivalent</h4>
                                            </div>
                                            <div class="col-mod-6 col-lg-3 alignment">
                                                <label>Examination:</label>
                                            </div>
                                            <div class="col-mod-6 col-lg-7">
                                                <select class="form-control" name="exam[]" required>
                                                    <option value="SSC">SSC</option>
                                                </select>
                                            </div>
                                            <div class="col-mod-6 col-lg-3 alignment">
                                                <label>Board</label>
                                            </div>
                                            <div class="col-mod-6 col-lg-7">
                                                <select class="form-control" name="board[]" required>
                                                    <option @php echo (isset($ssc->board) && $ssc->board=="Barisal")?"selected":""
                                                        @endphp value="Barisal">Barisal</option>
                                                    <option @php echo (isset($ssc->board) && $ssc->board=="Chittagong")?"selected":""
                                                        @endphp value="Chittagong">Chittagong</option>
                                                    <option @php echo (isset($ssc->board) && $ssc->board=="Comilla")?"selected":""
                                                        @endphp value="Comilla">Comilla</option>
                                                    <option @php echo (isset($ssc->board) && $ssc->board=="Dhaka")?"selected":"" @endphp
                                                        value="Dhaka">Dhaka</option>
                                                    <option @php echo (isset($ssc->board) && $ssc->board=="Jessore")?"selected":""
                                                        @endphp value="Jessore">Jessore</option>
                                                    <option @php echo (isset($ssc->board) && $ssc->board=="Mymensingh")?"selected":""
                                                        @endphp value="Mymensingh">Mymensingh</option>
                                                    <option @php echo (isset($ssc->board) && $ssc->board=="Madrashah")?"selected":""
                                                        @endphp value="Madrashah">Madrashah</option>
                                                    <option @php echo (isset($ssc->board) && $ssc->board=="Rajshahi")?"selected":""
                                                        @endphp value="Rajshahi">Rajshahi</option>
                                                    <option @php echo (isset($ssc->board) && $ssc->board=="Rangpur")?"selected":""
                                                        @endphp value="Rangpur">Rangpur</option>
                                                    <option @php echo (isset($ssc->board) && $ssc->board=="Sylhet")?"selected":""
                                                        @endphp value="Sylhet">Sylhet</option>
                                                    <option @php echo (isset($ssc->board) && $ssc->board=="Dinajpur")?"selected":""
                                                        @endphp value="Dinajpur">Dinajpur</option>
                                                </select>
                                            </div>
                                            <div class="col-mod-6 col-lg-3 alignment">
                                                <label>Result:</label>
                                            </div>
                                            <div class="col-mod-6 col-lg-7">
                                                <input type="text" class="form-control" placeholder="GPA"
                                                    name="result[]" value="{{ isset($ssc->result)?$ssc->result:'' }}" required>
                                            </div>
                                            <div class="col-mod-6 col-lg-3 alignment">
                                                <label>Passing Year:</label>
                                            </div>
                                            <div class="col-mod-6 col-lg-7">

                                                {!!
                                                Form::selectRange('year[]',date('Y'),1980,isset($ssc->passing_year)?$ssc->passing_year:''
                                                ,['class'=>'form-control p-1
                                                shadow-none','required']) !!}
                                            </div>
                                            <div class="col-mod-6 col-lg-3 alignment">
                                                <label>Roll:</label>
                                            </div>
                                            <div class="col-mod-6 col-lg-7">
                                                <input type="number" class="form-control" placeholder="Roll Number"
                                                    name="roll[]" value="{{ isset($ssc->roll)?$ssc->roll:'' }}" required>
                                            </div>
                                            <div class="col-mod-6 col-lg-3 alignment">
                                                <label>Duration:</label>
                                            </div>
                                            <div class="col-mod-6 col-lg-7">
                                                <input type="number" class="form-control" placeholder="Duration"
                                                    name="duration[]" value="{{ isset($ssc->duration)?$ssc->duration:'' }}" required>
                                            </div>
                                        </div>





                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row mx-0">
                                                    <div class="exam">
                                                        <h4>HSC/Equivalent</h4>
                                                    </div>
                                                    <div class="col-mod-6 col-lg-3 alignment">
                                                        <label>Examination:</label>
                                                    </div>
                                                    <div class="col-mod-6 col-lg-7">
                                                        <select class="form-control" name="exam[]" required>
                                                            <option value="HSC">HSC</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-mod-6 col-lg-3 alignment">
                                                        <label>Board</label>
                                                    </div>
                                                    <div class="col-mod-6 col-lg-7">
                                                            <select class="form-control" name="board[]" required>
                                                            <option @php echo (isset($ssc->board) && $ssc->board=="Barisal")?"selected":""
                                                                @endphp value="Barisal">Barisal</option>
                                                            <option @php echo (isset($ssc->board) && $ssc->board=="Chittagong")?"selected":""
                                                                @endphp value="Chittagong">Chittagong</option>
                                                            <option @php echo (isset($ssc->board) && $ssc->board=="Comilla")?"selected":""
                                                                @endphp value="Comilla">Comilla</option>
                                                            <option @php echo (isset($ssc->board) && $ssc->board=="Dhaka")?"selected":"" @endphp
                                                                value="Dhaka">Dhaka</option>
                                                            <option @php echo (isset($ssc->board) && $ssc->board=="Jessore")?"selected":""
                                                                @endphp value="Jessore">Jessore</option>
                                                            <option @php echo (isset($ssc->board) && $ssc->board=="Mymensingh")?"selected":""
                                                                @endphp value="Mymensingh">Mymensingh</option>
                                                            <option @php echo (isset($ssc->board) && $ssc->board=="Madrashah")?"selected":""
                                                                @endphp value="Madrashah">Madrashah</option>
                                                            <option @php echo (isset($ssc->board) && $ssc->board=="Rajshahi")?"selected":""
                                                                @endphp value="Rajshahi">Rajshahi</option>
                                                            <option @php echo (isset($ssc->board) && $ssc->board=="Rangpur")?"selected":""
                                                                @endphp value="Rangpur">Rangpur</option>
                                                            <option @php echo (isset($ssc->board) && $ssc->board=="Sylhet")?"selected":""
                                                                @endphp value="Sylhet">Sylhet</option>
                                                            <option @php echo (isset($ssc->board) && $ssc->board=="Dinajpur")?"selected":""
                                                                @endphp value="Dinajpur">Dinajpur</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-mod-6 col-lg-3 alignment">
                                                        <label>Result:</label>
                                                    </div>
                                                    <div class="col-mod-6 col-lg-7">
                                                        <input type="text" class="form-control" placeholder="GPA"
                                                            name="result[]" value="{{ isset($hsc->result)?$hsc->result:'' }}" required>
                                                    </div>
                                                    <div class="col-mod-6 col-lg-3 alignment">
                                                        <label>Passing Year:</label>
                                                    </div>
                                                    <div class="col-mod-6 col-lg-7">
                                                        {!!
                                                        Form::selectRange('year[]',date('Y'),1980,isset($hsc->passing_year)?$hsc->passing_year:''
                                                        ,['class'=>'form-control p-1
                                                        shadow-none','required']) !!}
                                                    </div>
                                                    <div class="col-mod-6 col-lg-3 alignment">
                                                        <label>Roll:</label>
                                                    </div>
                                                    <div class="col-mod-6 col-lg-7">
                                                        <input type="number" class="form-control"
                                                            placeholder="Roll Number" name="roll[]"
                                                            value="{{ isset($hsc->roll)?$hsc->roll:'' }}" required>
                                                    </div>
                                                    <div class="col-mod-6 col-lg-3 alignment">
                                                        <label>Duration:</label>
                                                    </div>
                                                    <div class="col-mod-6 col-lg-7">
                                                        <input type="number" class="form-control" placeholder="Duration"
                                                            name="duration[]" value="{{ isset($hsc->duration)?$hsc->duration:'' }}" required>
                                                    </div>
                                                </div>









                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row mx-0">
                                                            <div class="exam">
                                                                <h4>MBBS/BDS</h4>
                                                            </div>
                                                            <div class="col-mod-6 col-lg-3 alignment">
                                                                <label>Examination:</label>
                                                            </div>
                                                            <div class="col-mod-6 col-lg-7">
                                                                <select class="form-control" name="exam[]" required>
                                                                    <option value="MBBS/BDS">MBBS/BDS
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="col-mod-6 col-lg-3 alignment">
                                                                <label>Institute</label>
                                                            </div>
                                                            <div class="col-md-8 col-lg-7">
                                                                {!!
                                                                Form::select('board[]',$medical_colleges,
                                                                isset($mbbs_bds->board)?
                                                                $mbbs_bds->board : ''
                                                                ,['class'=>'form-select select2',
                                                                'required'=>'required']) !!}
                                                            </div>
                                                            <div class="col-mod-6 col-lg-3 alignment">
                                                                <label>Result:</label>
                                                            </div>
                                                            <div class="col-mod-6 col-lg-7">
                                                                <input type="text" class="form-control"
                                                                    placeholder="CGPA/Percentage" name="result[]"
                                                                    value="{{ isset($mbbs_bds->result)?$mbbs_bds->result:'' }}" required>
                                                            </div>
                                                            <div class="col-mod-6 col-lg-3 alignment">
                                                                <label>Passing Year:</label>
                                                            </div>
                                                            <div class="col-mod-6 col-lg-7">
                                                                {!!
                                                                Form::selectRange('year[]',date('Y'),1980,isset($mbbs_bds->passing_year)?$mbbs_bds->passing_year:''
                                                                ,['class'=>'form-control p-1
                                                                shadow-none','required']) !!}
                                                            </div>
                                                            <div class="col-mod-6 col-lg-3 alignment">
                                                                <label>Roll:</label>
                                                            </div>
                                                            <div class="col-mod-6 col-lg-7">
                                                                <input type="number" class="form-control"
                                                                    placeholder="Roll Number" name="roll[]"
                                                                    value="{{ isset($mbbs_bds->roll)?$mbbs_bds->roll:'' }}" required>
                                                            </div>
                                                            <div class="col-mod-6 col-lg-3 alignment">
                                                                <label>Duration:</label>
                                                            </div>
                                                            <div class="col-mod-6 col-lg-7">
                                                                <input type="number" class="form-control"
                                                                    placeholder="Duration" name="duration[]"
                                                                    value="{{ isset($mbbs_bds->duration)?$mbbs_bds->duration:'' }}" required>
                                                            </div>
                                                        </div>





                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row mx-0">
                                                                    <div class="exam">
                                                                        <h4>Post-Graduation<label
                                                                                class="optional">(optional)</label>
                                                                        </h4>
                                                                    </div>
                                                                    <div class="col-mod-6 col-lg-3 alignment">
                                                                        <label>Examination:</label>
                                                                    </div>
                                                                    <div class="col-mod-6 col-lg-7">
                                                                        <select class="form-control" name="exam[]">
                                                                            <option value="Post-Graduation">
                                                                                Post-Graduation</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-mod-6 col-lg-3 alignment">
                                                                        <label>Institute</label>
                                                                    </div>
                                                                    <div class="col-md-8 col-lg-7">
                                                                        <input type="text" class="form-control"
                                                                            name="board[]" placeholder="Institute Name"
                                                                            value="{{ isset($post_graduation->board)?$post_graduation->board:''}}">
                                                                    </div>
                                                                    <div class="col-mod-6 col-lg-3 alignment">
                                                                        <label>Result:</label>
                                                                    </div>
                                                                    <div class="col-mod-6 col-lg-7">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="CGPA/Percentage"
                                                                            name="result[]"
                                                                            value="{{ isset($post_graduation->result)?$post_graduation->result:''}}">

                                                                    </div>
                                                                    <div class="col-mod-6 col-lg-3 alignment">
                                                                        <label>Passing Year:</label>
                                                                    </div>
                                                                    <div class="col-mod-6 col-lg-7">

                                                                        {!!
                                                                        Form::selectRange('year[]',date('Y'),1980,isset($post_graduation->passing_year)?$post_graduation->passing_year:''
                                                                        ,['class'=>'form-control p-1
                                                                        shadow-none']) !!}
                                                                    </div>
                                                                    <div class="col-mod-6 col-lg-3 alignment">
                                                                        <label>Roll:</label>
                                                                    </div>
                                                                    <div class="col-mod-6 col-lg-7">
                                                                        <input type="number" class="form-control"
                                                                            placeholder="Roll Number" name="roll[]" value="{{ isset($post_graduation->roll)?$post_graduation->roll:''}}">
                                                                    </div>
                                                                    <div class="col-mod-6 col-lg-3 alignment">
                                                                        <label>Duration:</label>
                                                                    </div>
                                                                    <div class="col-mod-6 col-lg-7">
                                                                        <input type="number" class="form-control"
                                                                            placeholder="Duration" name="duration[]" value="{{ isset($post_graduation->duration)?$post_graduation->duration:''}}">
                                                                    </div>


                                                                    <div class="form-actions">
                                                                        <div class="row">
                                                                            <div class="col-md-offset-0 col-md-9">
                                                                                {{--                                         <button type="submit" class="btn btn-info">Save Profile</button>--}}
                                                                                <input type="submit"
                                                                                    class="btn btn-info"
                                                                                    value="Save Profile">
                                                                                <a href="{{ url('my-profile') }}"
                                                                                    class="btn btn-default">Cancel</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    {!! Form::close() !!}

                                                                    <!-- END FORM-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endsection

                                    @section('js')

                                    <link rel="stylesheet"
                                        href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
                                    <link rel="stylesheet"
                                        href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
                                    <script
                                        src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js">
                                    </script>

                                    <script type="text/javascript">
                                        $(document).ready(function () {

                                            $('#datepicker').datepicker({
                                                format: 'yyyy-mm-dd',
                                                startDate: '1900-01-01',
                                                endDate: '2020-12-30',
                                            }).on('changeDate', function (e) {
                                                $(this).datepicker('hide');
                                            });

                                            $("body").on("change", "[name='permanent_division_id']",
                                                function () {
                                                    var permanent_division_id = $(this).val();
                                                    $.ajax({
                                                        headers: {
                                                            'X-CSRF-TOKEN': $(
                                                                'meta[name="csrf-token"]'
                                                            ).attr(
                                                                'content')
                                                        },
                                                        type: "POST",
                                                        url: '/permanent-division-district',
                                                        dataType: 'HTML',
                                                        data: {
                                                            permanent_division_id: permanent_division_id
                                                        },
                                                        success: function (data) {
                                                            $('.permanent_district')
                                                                .html(data);
                                                            $('.permanent_upazila')
                                                                .html('');
                                                        }
                                                    });
                                                });

                                            $("body").on("change", "[name='permanent_district_id']",
                                                function () {
                                                    var permanent_district_id = $(this).val();
                                                    $.ajax({
                                                        headers: {
                                                            'X-CSRF-TOKEN': $(
                                                                'meta[name="csrf-token"]'
                                                            ).attr(
                                                                'content')
                                                        },
                                                        type: "POST",
                                                        url: '/permanent-district-upazila',
                                                        dataType: 'HTML',
                                                        data: {
                                                            permanent_district_id: permanent_district_id
                                                        },
                                                        success: function (data) {
                                                            $('.permanent_upazila')
                                                                .html(data);
                                                        }
                                                    });
                                                });

                                            $("body").on("change", "[name='present_division_id']",
                                                function () {
                                                    var present_division_id = $(this).val();
                                                    $.ajax({
                                                        headers: {
                                                            'X-CSRF-TOKEN': $(
                                                                'meta[name="csrf-token"]'
                                                            ).attr(
                                                                'content')
                                                        },
                                                        type: "POST",
                                                        url: '/present-division-district',
                                                        dataType: 'HTML',
                                                        data: {
                                                            present_division_id: present_division_id
                                                        },
                                                        success: function (data) {
                                                            $('.present_district')
                                                                .html(data);
                                                            $('.present_upazila')
                                                                .html('');
                                                        }
                                                    });
                                                });

                                            $("body").on("change", "[name='present_district_id']",
                                                function () {
                                                    var present_district_id = $(this).val();
                                                    $.ajax({
                                                        headers: {
                                                            'X-CSRF-TOKEN': $(
                                                                'meta[name="csrf-token"]'
                                                            ).attr(
                                                                'content')
                                                        },
                                                        type: "POST",
                                                        url: '/present-district-upazila',
                                                        dataType: 'HTML',
                                                        data: {
                                                            present_district_id: present_district_id
                                                        },
                                                        success: function (data) {
                                                            $('.present_upazila')
                                                                .html(data);
                                                        }
                                                    });
                                                });
                                        });
                                    </script>


                                    @endsection