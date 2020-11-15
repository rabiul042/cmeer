<!--<div class="form-group">-->
    <div class="">
        @php  $districts->prepend('Select District', ''); @endphp
        {!! Form::select('present_district_id',$districts, old('present_district_id'),['class'=>'form-control p-1 shadow-none','required']) !!}<i></i>
    </div>
<!--</div>-->