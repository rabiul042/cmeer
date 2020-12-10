@extends('layouts.app')
@section('content')
<div class="jumbotron text-center">
  <h1 class="border border-success">Registration Form</h1>
</div>


<!-- ================= Basic Information  ================== -->

<div class="container">
  <form action="{{url('register-first-step-submit')}}" method="post" enctype="multipart/form-data" autocomplete="off">
    {{ csrf_field() }}
    <div class="row">
      <div class="col-md-2">
        <!-- <div><img src="images/Group 2464.png" alt="img"></div> -->
      </div>
      <div class="col-md-8">


        <div>
          @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
        </div>
        {{-- <div class="basic-info">
          <h4><a href=""><u>Basic Information</u></a></h4>
        </div> --}}

        <div class="row mx-0">
          {{-- <div class="col-md-4 col-lg-3">
            <label>Applicant's ID:</label>
          </div>
          <div class="col-md-8 col-lg-9">
            <input type="number" class="form-control" placeholder="(Office Use Only)">
          </div> --}}
          <div class="col-md-4 col-lg-3 alignment">
            <label>Name:</label>
          </div>
          <div class="col-md-8 col-lg-9">
            <input type="text" class="form-control" name="name" placeholder="Full Name" required autocomplete="off">
          </div>

          <div class="col-md-4 col-lg-3 alignment">
            <label>Contact Mobile:</label>
          </div>
          <div class="col-md-8 col-lg-9">
            <input type="number" class="form-control" name="mobile_number" placeholder="Mobile Number" required  autocomplete="off">
          </div>

          <div class="col-md-4 col-lg-3 alignment">
            <label>Email:</label>
          </div>
          <div class="col-md-8 col-lg-9">
            <input type="email" class="form-control" name="email" placeholder="yourmail@gmail.com" required  autocomplete="off">
          </div>

          <div class="col-md-4 col-lg-3 alignment">
            <label>Medical College:</label>
          </div>
          <div class="col-md-8 col-lg-9">

            @php $medical_colleges->prepend('Medical College Name', ''); @endphp
            {!! Form::select('medical_college_id',$medical_colleges, ''
            ,['class'=>'form-select select2','required'=>'required', 'id'=>'medical_college_id'])
            !!}
          </div>
          <div class="col-md-4 col-lg-3 alignment">
            <label>User ID</label>
          </div>
          <div class="col-md-8 col-lg-9">

            <input type="text" class="form-control" name="bmdc_no" placeholder="BMDC No. or 6 digit [EX:A012345]"
              required  autocomplete="off">

          </div>


          <div class="col-mod-4 col-lg-3 alignment">
            <label>Password:</label>
          </div>
          <div class="col-mod-8 col-lg-9">
            <input type="password" class="form-control" name="password" placeholder="Password" required autocomplete="off">
            {{-- <i toggle=".password-field" class="fa fa-fw fa-eye field-icon toggle-password"></i> --}}
          </div>
          {{-- <div class="col-md-4 col-lg-3 alignment">
            <label>Profile Picture:</label>
          </div>
          <div class="col-md-8 col-lg-9">
            <input type="file" class="image" alt="img" name="image" required>
          </div> --}}
        </div>
      </div>
    </div>


    <!-- ================= End Basic Information ================== -->

    {{-- 
    <!-- ================= Additional Information  ================== -->

    <div class="row">
      <div class="col-md-2">
      </div>
      <div class="col-md-8">
        <div class="additional_info">
          <h4><a href=""><u>Additional Information</u></a></h4>
        </div>
        <div class="row mx-0">
          <div class="col-md-4 col-lg-3 alignment">
            <label>Father's Name:</label>
          </div>
          <div class="col-md-8 col-lg-9">
            <input type="text" class="form-control" placeholder="Father's Name" name="father_name" required>
          </div>
          <div class="col-md-4 col-lg-3 alignment">
            <label>Mother's Name:</label>
          </div>
          <div class="col-md-8 col-lg-9">
            <input type="text" class="form-control" placeholder="Mother's Name" name="mother_name" required>
          </div>
          <div class="col-md-4 col-lg-3 alignment">
            <label>Date of Birth:</label>
          </div>
          <div class="col-md-8 col-lg-9">
            <input type="date" class="birthdate" placeholder="Birthdate" name="date_of_birth" required>
          </div>
          <div class="col-md-4 col-lg-3 alignment">
            <label>Gender:</label>
          </div>
          <div class="col-md-8 col-lg-9 gender">
            <input type="radio" class="gender" name="gender" value="Male" required> Male
            <input type="radio" class="gender" name="gender" value="Female" required> Female
            <input type="radio" class="gender" name="gender" value="Other" required> Other
          </div>
          <div class="col-md-4 col-lg-3 alignment">
            <label>National ID No:</label>
          </div>
          <div class="col-md-8 col-lg-9">
            <input type="number" class="form-control" placeholder="NID Number" name="nid" required>
          </div>
          <!-- <div class="col-md-4 col-lg-3">
            <label>Nationality:</label>
          </div>
          <div class="col-md-8 col-lg-9">
            <input type="text" class="form-control" placeholder="Bangladeshi">
          </div>
          <div class="col-md-4 col-lg-3">
            <label>Maritial Status:</label>
          </div>
          <div class="col-md-8 col-lg-9">
            <select class="maritialstatus">
              <option value="select">Select Status</option>
              <option value="married">Married</option>
              <option value="unmarried">Unmarried</option>
              <option value="divorced">Divorced</option>
            </select>
          </div> -->
          <div class="col-md-4 col-lg-3 alignment">
            <label>Employment Status:</label>
          </div>
          <div class="col-md-8 col-lg-9">
            <input type="text" class="form-control" placeholder="Employement Status(if any)" name="job_description">
          </div>
        </div>
      </div>
    </div>

    <!-- ================= End Additional Information  ================== -->


    <!-- ================= Address ================== -->

    <div class="row">
      <div class="col-md-0">
      </div>
      <div class="col-md-12">
        <div class="address">
          <h4><a href=""><u>Present Address</u></a></h4>
        </div>
        <div class="row mx-0">
          <div class="panel-body">
            <div class="form-group">
              <div class="row row-col-3 pt-1 price-details my-0">
                <div class="col pr-0">
                  @php $divisions->prepend('Select Division', ''); @endphp
                  {!! Form::select('present_division_id',$divisions,
                  old('present_division_id')?old('present_division_id'):'' ,['class'=>'form-control p-1
                  shadow-none','required']) !!}<i></i>
                </div>

                <div class="present_district col pr-0 pl-1">

                </div>

                <div class="present_upazila col pr-0">

                </div>

              </div>
            </div>
            <div class="form-group">
              <label class="col-md-1 control-label">Address</label>
              <div class="col-md-3" style="width: 40%;">
                <div class="input-icon right">
                  <textarea class="form-control" rows="3" style="height: 100px; width=25%;" name="present_address"
                    required>{{ old('present_address')?old('present_address'):'' }}</textarea>
</div>
</div>
</div>
</div>
</div>
</div>
</div>



<div class="row">
  <div class="col-md-0">
  </div>
  <div class="col-md-12">
    <div class="address">
      <h4><a href=""><u>Permanent Address</u></a></h4>
    </div>
    <div class="row mx-0">
      <div class="panel-body">
        <div class="form-group">
          <div class="row row-col-3 pt-1 price-details my-0">
            <div class="col pr-0">
              @php $divisions->prepend('Select Division', ''); @endphp
              {!! Form::select('permanent_division_id',$divisions,
              old('permanent_division_id')?old('permanent_division_id'):'' ,['class'=>'form-control p-1
              shadow-none','required']) !!}<i></i>
            </div>

            <div class="permanent_district col pr-0 pl-1">

            </div>

            <div class="permanent_upazila col pr-0">

            </div>

          </div>
        </div>
        <div class="form-group">
          <label class="col-md-1 control-label">Address</label>
          <div class="col-md-3" style="width: 40%;">
            <div class="input-icon right">
              <textarea class="form-control" rows="3" style="height: 100px; width=25%;" name="permanent_address"
                required>{{ old('permanent_address')?old('permanent_address'):'' }}</textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!--  ================= End Address ================== -->


<!-- /* ================= Educational Qualification  ================== */ -->

<div class="education">
  <h3><a href=""><u>Educational Qualification</u></a></h3>
</div>


<!-- /* ================= SSC Examination ================== */ -->

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
          <option value selected="selected">Select Board</option>
          <option value="Barisal">Barisal</option>
          <option value="Chittagong">Chittagong</option>
          <option value="Comilla">Comilla</option>
          <option value="Dhaka">Dhaka</option>
          <option value="Jessore">Jessore</option>
          <option value="Mymensingh">Mymensingh</option>
          <option value="Madrashah">Madrashah</option>
          <option value="Rajshahi">Rajshahi</option>
          <option value="Rajshahi">Rangpur</option>
          <option value="Sylhet">Sylhet</option>
          <option value="Dinajpur">Dinajpur</option>
        </select>
      </div>
      <div class="col-mod-6 col-lg-3 alignment">
        <label>Result:</label>
      </div>
      <div class="col-mod-6 col-lg-7">
        <input type="text" class="form-control" placeholder="GPA" name="result[]" required>
      </div>
      <div class="col-mod-6 col-lg-3 alignment">
        <label>Passing Year:</label>
      </div>
      <div class="col-mod-6 col-lg-7">

        {!! Form::selectRange('year[]',date('Y'),1980,date('Y') ,['class'=>'form-control p-1
        shadow-none','required']) !!}
      </div>
      <div class="col-mod-6 col-lg-3 alignment">
        <label>Roll:</label>
      </div>
      <div class="col-mod-6 col-lg-7">
        <input type="number" class="form-control" placeholder="Roll Number" name="roll[]" required>
      </div>
      <div class="col-mod-6 col-lg-3 alignment">
        <label>Duration:</label>
      </div>
      <div class="col-mod-6 col-lg-7">
        <input type="number" class="form-control" placeholder="Duration" name="duration[]" required>
      </div>
    </div>
  </div>
</div>

<!-- /* ================= End SSC Examination  ================== */
        
        

        /* ================= HSC Examination  ================== */ -->

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
          <option value selected="selected">Select Board</option>
          <option value="Barisal">Barisal</option>
          <option value="Chittagong">Chittagong</option>
          <option value="Comilla">Comilla</option>
          <option value="Dhaka">Dhaka</option>
          <option value="Jessore">Jessore</option>
          <option value="Mymensingh">Mymensingh</option>
          <option value="Madrashah">Madrashah</option>
          <option value="Rajshahi">Rajshahi</option>
          <option value="Rajshahi">Rangpur</option>
          <option value="Sylhet">Sylhet</option>
          <option value="Dinajpur">Dinajpur</option>
        </select>
      </div>
      <div class="col-mod-6 col-lg-3 alignment">
        <label>Result:</label>
      </div>
      <div class="col-mod-6 col-lg-7">
        <input type="text" class="form-control" placeholder="GPA" name="result[]" required>
      </div>
      <div class="col-mod-6 col-lg-3 alignment">
        <label>Passing Year:</label>
      </div>
      <div class="col-mod-6 col-lg-7">

        {!! Form::selectRange('year[]',date('Y'),1980,date('Y') ,['class'=>'form-control p-1
        shadow-none','required']) !!}
      </div>
      <div class="col-mod-6 col-lg-3 alignment">
        <label>Roll:</label>
      </div>
      <div class="col-mod-6 col-lg-7">
        <input type="number" class="form-control" placeholder="Roll Number" name="roll[]" required>
      </div>
      <div class="col-mod-6 col-lg-3 alignment">
        <label>Duration:</label>
      </div>
      <div class="col-mod-6 col-lg-7">
        <input type="number" class="form-control" placeholder="Duration" name="duration[]" required>
      </div>
    </div>
  </div>
</div>

<!-- ================= End HSC Examination  ================== -->


<!-- ================= MBBS/BDS Examination  ================== -->

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
          <option value="MBBS/BDS">MBBS/BDS</option>
        </select>
      </div>
      <div class="col-mod-6 col-lg-3 alignment">
        <label>Institute</label>
      </div>
      <div class="col-md-8 col-lg-7">
        @php $medical_colleges->prepend('Medical College Name', ''); @endphp
        {!! Form::select('board[]',$medical_colleges, ''
        ,['class'=>'form-select select2','required'=>'required', 'id'=>'medical_college_id'])
        !!}
      </div>
      <div class="col-mod-6 col-lg-3 alignment">
        <label>Result:</label>
      </div>
      <div class="col-mod-6 col-lg-7">
        <input type="text" class="form-control" placeholder="CGPA/Percentage" name="result[]" required>
      </div>
      <div class="col-mod-6 col-lg-3 alignment">
        <label>Passing Year:</label>
      </div>
      <div class="col-mod-6 col-lg-7">

        {!! Form::selectRange('year[]',date('Y'),1980,date('Y') ,['class'=>'form-control p-1
        shadow-none','required']) !!}
      </div>
      <div class="col-mod-6 col-lg-3 alignment">
        <label>Roll:</label>
      </div>
      <div class="col-mod-6 col-lg-7">
        <input type="number" class="form-control" placeholder="Roll Number" name="roll[]" required>
      </div>
      <div class="col-mod-6 col-lg-3 alignment">
        <label>Duration:</label>
      </div>
      <div class="col-mod-6 col-lg-7">
        <input type="number" class="form-control" placeholder="Duration" name="duration[]" required>
      </div>
    </div>
  </div>
</div>

<!-- ================= End MBBS/BDS Examination  ================== -->


<!-- ================= Post-Graduation Examination  ================== -->

<div class="row">
  <div class="col-md-12">
    <div class="row mx-0">
      <div class="exam">
        <h4>Post-Graduation<label class="optional">(optional)</label></h4>
      </div>
      <div class="col-mod-6 col-lg-3 alignment">
        <label>Examination:</label>
      </div>
      <div class="col-mod-6 col-lg-7">
        <select class="form-control" name="exam[]">
          <option value="Post-Graduation">Post-Graduation</option>
        </select>
      </div>
      <div class="col-mod-6 col-lg-3 alignment">
        <label>Institute</label>
      </div>
      <div class="col-md-8 col-lg-7">
        <input type="text" class="form-control" name="board[]" placeholder="Institute Name">
      </div>
      <div class="col-mod-6 col-lg-3 alignment">
        <label>Result:</label>
      </div>
      <div class="col-mod-6 col-lg-7">
        <input type="text" class="form-control" placeholder="CGPA/Percentage" name="result[]">

      </div>
      <div class="col-mod-6 col-lg-3 alignment">
        <label>Passing Year:</label>
      </div>
      <div class="col-mod-6 col-lg-7">

        {!! Form::selectRange('year[]',date('Y'),1980,date('Y') ,['class'=>'form-control p-1
        shadow-none']) !!}
      </div>
      <div class="col-mod-6 col-lg-3 alignment">
        <label>Roll:</label>
      </div>
      <div class="col-mod-6 col-lg-7">
        <input type="number" class="form-control" placeholder="Roll Number" name="roll[]">
      </div>
      <div class="col-mod-6 col-lg-3 alignment">
        <label>Duration:</label>
      </div>
      <div class="col-mod-6 col-lg-7">
        <input type="number" class="form-control" placeholder="Duration" name="duration[]">
      </div>
    </div>

  </div>
</div>
--}}
<input class="save" type="submit" value="Save" name="save">
</form>

</div>
<!-- ================= End Post Graduation Examination  ================== -->


@endsection

@section('js')
<script>
  $(document).ready(function () {

    $("body").on("change", "[name='permanent_division_id']", function () {
      var permanent_division_id = $(this).val();
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: '/permanent-division-district',
        dataType: 'HTML',
        data: {
          permanent_division_id: permanent_division_id
        },
        success: function (data) {
          $('.permanent_district').html(data);
          $('.permanent_upazila').html('');
        }
      });
    });

    $("body").on("change", "[name='permanent_district_id']", function () {
      var permanent_district_id = $(this).val();
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: '/permanent-district-upazila',
        dataType: 'HTML',
        data: {
          permanent_district_id: permanent_district_id
        },
        success: function (data) {
          $('.permanent_upazila').html(data);
        }
      });
    });

    $("body").on("change", "[name='present_division_id']", function () {
      var present_division_id = $(this).val();
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: '/present-division-district',
        dataType: 'HTML',
        data: {
          present_division_id: present_division_id
        },
        success: function (data) {
          $('.present_district').html(data);
          $('.present_upazila').html('');
        }
      });
    });

    $("body").on("change", "[name='present_district_id']", function () {
      var present_district_id = $(this).val();
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: '/present-district-upazila',
        dataType: 'HTML',
        data: {
          present_district_id: present_district_id
        },
        success: function (data) {
          $('.present_upazila').html(data);
        }
      });
    });
  });
</script>
@endsection