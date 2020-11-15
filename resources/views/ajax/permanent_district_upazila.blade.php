<!--<div class="form-group">-->
    <div class="">
        @php  $upazilas->prepend('Select Upazila', ''); @endphp
        {!! Form::select('permanent_upazila_id',$upazilas, old('permanent_upazila_id'),['class'=>'form-control p-1 shadow-none','required']) !!}<i></i>
    </div>
<!--</div>-->