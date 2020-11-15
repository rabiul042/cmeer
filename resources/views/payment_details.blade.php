@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">

            @include('side_bar')

            <div class="col-md-9 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#7fc9f6; color: #FFFFFF;"><h3>Payment Details</h3></div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="col-md-12">
                            <div class="portlet">
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover datatable">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Reg. No.</th>
                                            <th>Year</th>
                                            <th>Session</th>
                                            <th>Course</th>
                                            <th>Batch</th>
                                            <th>Admission Fee</th>
                                            <th>Payable Amount</th>
                                            <th>Due</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($course_info as $k=> $course)
                                            @if($course->is_trash=='0')

                                                <tr>
                                                    <td>{{ $k+1 }}</td>
                                                    <td>{{ $course->reg_no }}</td>
                                                    <td>{{ $course->year }}</td>
                                                    <td>{{ (isset($course->session->name))?$course->session->name:'' }}</td>
                                                    <td>{{ (isset($course->course->name))?$course->course->name:'' }}</td>
                                                    <td>{{ (isset($course->batch->name))?$course->batch->name:'' }}</td>
                                                    <td>{{ (isset($course->actual_course_price))?$course->actual_course_price:'' }}</td>
                                                    <td>{{ (isset($course->course_price))?$course->course_price:'' }}</td>
                                                    <td>

                                                        @if($course->payment_status=='Completed')
                                                            0
                                                        @else
                                                            @php
                                                                $temp_name = \App\DoctorCoursePayment::select('*')
                                                                ->where(['doctor_course_id' => $course->id, 'status' => 'Verified' ])->get();

                                                                $paid_amount=0;
                                                                $total_row=0;
                                                                foreach ($temp_name as $key => $paid){
                                                                    $paid_amount=$paid_amount+$paid->amount;
                                                                    $total_row=$total_row+1;
                                                                }
                                                                $paid_amount;
                                                                echo $course->course_price-$paid_amount;

                                                            @endphp
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{--@if((isset($course->course_price)) && (isset($course->batch->id)))--}}
                                                        @if(isset($course->batch->id))
                                                            @if($course->payment_status == 'Completed')
                                                                <span class="btn btn-xs btn-primary" style="background-color:Green;">Paid</span>
                                                            @elseif($course->payment_status == 'Requested')
                                                                <span class="btn btn-xs btn-primary" style="background-color: #ff7700;">Requested</span>
                                                            @else
                                                                @if($course->course_price!=$paid_amount)
                                                                    <a class="btn btn-xs btn-primary"  href="{{url('payment/'.$course['id'])}}">Pay Now</a>
                                                                    <div class='modal fade' id='myModal_{{$course->id}}' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
                                                                        <div class='modal-dialog' role='document'>
                                                                            <div class='modal-content'>
                                                                                <div class='modal-header'>
                                                                                    <h4 class='modal-title' id='myModalLabel'>Pay Now</h4>
                                                                                </div>
                                                                                <div class='modal-body'>
                                                                                    {!! Form::open(['url'=>['https://banglamedexam.com/user-login-sif-payment'],'method'=>'get','files'=>true,'class'=>'form-horizontal']) !!}
                                                                                    <h4>Payable Amount : {{$course->course_price}}</h4>
                                                                                    <h5>Paid Amount : {{$paid_amount}}</h5>
                                                                                    <h5>Due Amount : {{$course->course_price-$paid_amount}}</h5>
                                                                                <!-- <h5>Minimum Payable : {{$course->course_price/100*$course->batch->minimum_payment}} ({{$course->batch->minimum_payment}}%)</h5><br> -->
                                                                                    <input type="hidden" name="name" required value="{{$doc_info->name}}">
                                                                                    <input type="hidden" name="password" required value="123456">
                                                                                    <input type="hidden" name="email" required value="{{$doc_info->email}}">
                                                                                    <input type="hidden" name="bmdc" required value="{{$doc_info->bmdc_no}}">
                                                                                    <input type="hidden" name="phone" required value="{{$doc_info->mobile_number}}">
                                                                                    <input type="hidden" name="doctor_id" required value="{{$doc_info->id}}">
                                                                                    <input type="hidden" name="regi_no" required value="{{$course->reg_no}}">
                                                                                    <input type="hidden" name="doctor_course_id" required value="{{$course->id}}" class="form-control">
                                                                                    @if ($total_row==0)
                                                                                        <input type="number" name="amount" required value="{{$course->course_price-$paid_amount}}" class="form-control"
                                                                                               min="{{$course->course_price/100*$course->batch->minimum_payment}}" max="{{$course->course_price-$paid_amount}}"><br>
                                                                                        <input type="hidden" name="payment_serial" required value="1">
                                                                                    @elseif ($course->batch->payment_times == $total_row+1)
                                                                                        <input type="number" name="amount" required value="{{$course->course_price-$paid_amount}}" class="form-control"
                                                                                               min="{{$course->course_price-$paid_amount}}" max="{{$course->course_price-$paid_amount}}"><br>
                                                                                        <input type="hidden" name="payment_serial" required value="{{$total_row+1}}">
                                                                                    @else
                                                                                        <input type="number" name="amount" required value="{{$course->course_price-$paid_amount}}" class="form-control"
                                                                                               min="10" max="{{$course->course_price-$paid_amount}}"><br>
                                                                                        <input type="hidden" name="payment_serial" required value="{{$total_row+1}}">
                                                                                    @endif
                                                                                    <input type="submit" value="Submit" class="btn btn-xm btn-primary">
                                                                                    {!! Form::close() !!}
                                                                                </div>
                                                                                <div class='modal-footer'>
                                                                                    <button type='button' class='btn btn-sm bg-red' data-dismiss='modal'>Close</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <span class="btn btn-xs btn-primary" style="background-color:Green;">Paid</span>
                                                                @endif

                                                            @endif

                                                        @else
                                                            No full Data
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>

                                    <?php
                                        if(isset($last_reg->payment_status)){
                                            if (($last_reg->payment_status=='Requested')) {
                                                echo "<div class='alert alert-success'>Dear Dr, Your payment approval request send successfully. You will get a confirm email.  </div>";
                                            }
                                            elseif (($last_reg->payment_status!='Completed') && (isset($last_reg_pay->minimum_payment)) && (substr($last_reg->created_at,0,10)==date('Y-m-d'))) {
                                                echo "<div class='alert alert-danger'>You must pay {$last_reg_pay->minimum_payment}% of your total course fee within 24 hours. Otherwise your submitted form will be deleted automatically and you need to submit admission form again. You may not get admitted in the batch you selected previously during form fill up if the batch capacity become full by this time.</div>";
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
