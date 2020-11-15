@extends('layouts.app')
@section('content')
<div class="jumbotron text-center">
  <h1>Registration Form</h1>
</div>

<div class="container">
  <form action="{{url('register-second-step-submit')}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
      <div class="col-md-2">
      </div>
      <div class="col-md-8">
        <div class="additional_info">
          <h4><a href=""><u>Additional Information</u></a></h4>
        </div>
        <div class="row mx-0">
          <input type="hidden" name="id" value="{{$id}}">
          <div class="col-md-4 col-lg-3">
            <label>Father's Name:</label>
          </div>
          <div class="col-md-8 col-lg-9">
            <input type="text" class="form-control" placeholder="Type Your Father Name" name="father_name" required>
          </div>
          <div class="col-md-4 col-lg-3">
            <label>Mother's Name:</label>
          </div>
          <div class="col-md-8 col-lg-9">
            <input type="text" class="form-control" placeholder="Type Your Mother Name" name="mother_name" required>
          </div>
          <div class="col-md-4 col-lg-3">
            <label>Date of Birth:</label>
          </div>
          <div class="col-md-8 col-lg-9">
            <input type="date" class="birthdate" placeholder="Type Your Birthdate" name="date_of_birth" required>
          </div>
          <div class="col-md-4 col-lg-3">
            <label>Gender:</label>
          </div>
          <div class="col-md-8 col-lg-9 gender">
            <input type="radio" class="gender" name="gender" value="Male" required> Male
            <input type="radio" class="gender" name="gender" value="Female" required> Female
            <input type="radio" class="gender" name="gender" value="Other" required> Other
          </div>
          <div class="col-md-4 col-lg-3">
            <label>National ID No:</label>
          </div>
          <div class="col-md-8 col-lg-9">
            <input type="number" class="form-control" placeholder="Type Your NID Number" name="nid" required>
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
          <div class="col-md-4 col-lg-3">
            <label>Employment Status:</label>
          </div>
          <div class="col-md-8 col-lg-9">
            <input type="text" class="form-control" placeholder="Employement Status(if any)" name="job_description">
          </div>
        </div>



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
                  <div>
                    <label>Division</label>
                  </div>
                  <div class="row row-col-3 pt-1 price-details my-0">
                    <div class="col pr-0">
                      @php $divisions->prepend('Select Division', ''); @endphp
                      {!! Form::select('present_division_id',$divisions,
                      old('present_division_id')?old('present_division_id'):'' ,['class'=>'form-control p-1 shadow-none','required']) !!}<i></i>
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
                      <textarea class="form-control" rows="3" style="height: 100px; width=25%;" 
                        name="present_address" required>{{ old('present_address')?old('present_address'):'' }}</textarea>
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
                      old('permanent_division_id')?old('permanent_division_id'):'' ,['class'=>'form-control p-1 shadow-none','required']) !!}<i></i>
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
                      <textarea class="form-control" rows="3" style="height: 100px; width=25%;" 
                        name="permanent_address" required>{{ old('permanent_address')?old('permanent_address'):'' }}</textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <input type="submit" class="savenext1" value="Save & Next">
      </div>
  </form>
</div>
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