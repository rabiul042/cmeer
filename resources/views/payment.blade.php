@extends('layouts.app')
@section('content')

<div class="container">

    <div class="row">

        @include('side_bar')
        <div class="col-md-9 col-md-offset-0">

            <div class="row panel panel-default">
                {!!Form::open(['url'=>'payment-create/'.$doctor->id.'/'.$course_info['id'],'method'=>'post','files'=>true,'class'=>'form-horizontal'])!!}
                <div class="row col-md-9">
                    <div class="col-md-8">
                        <h4>Payable Amount : {{$course_info->course_price}}</h4>
                        <h5>Due Amount : {{$course_info->course_price}}</h5>
                        <input type="number" name="amount" required value="{{$course_info->course_price}}"
                            class="form-control amount_1"
                            min="{{$course_info->course_price/100*$course_info->batch->minimum_payment}}"
                            max="{{$course_info->course_price}}"><br>
                    </div>
                    <div class="col-md-8">
                        <select name="payment_type" id="select_box" class="form-select" onchange="onChangeSelectBox()">
                            <option value="bkash">Bkash</option>
                            <option value="bank">Bank</option>
                        </select>
                    </div>
                    <div id="field_box" class="col-md-8 mt-2">
                        <div class="card card-body border">
                            <input class="form-control" name="mobile_or_name" type="text" placeholder="Mobile Number" required>
                            <input class="form-control mt-1" name="transaction_or_account" type="text" placeholder="Transaction ID" required>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-xm btn-primary" >Send Request Approval</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>




    </div>
</div>
</div>
</div>

@endsection

@section('js')
<script>
    const selectBox = document.getElementById('select_box')
    const fieldBox = document.getElementById('field_box')

    function onChangeSelectBox(){
        if(selectBox.value == 'bkash'){
            fieldBox.innerHTML = '<input class="form-control" name="mobile_or_name" type="text" placeholder="Mobile Number" required><input class="form-control mt-1" name="transaction_or_account" type="text" placeholder="Transaction ID" required>'
        }
        if(selectBox.value == 'bank'){
            fieldBox.innerHTML = '<input class="form-control" name="mobile_or_name" type="text" placeholder="Account Name" required><input class="form-control mt-1" name="transaction_or_account" type="text" placeholder="Account Number" required>'
        }
    }
</script>
@endsection