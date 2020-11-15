<div class="sessions">
    <div class="form-group">
        <label class="col-md-3 control-label">Sessions (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
        <div class="col-md-3">
            @php  $sessions->prepend('Select Session', ''); @endphp
            {!! Form::select('session_id',$sessions,'',['class'=>'form-control','required'=>'required','id'=>'session_id']) !!}<i></i>
        </div>
    </div>
</div>

<div class="faculties">
    <div class="form-group">
        <label class="col-md-3 control-label">Faculty (<i class="fa fa-asterisk ipd-star" style="font-size:9px;"></i>) </label>
        <div class="col-md-3">
            @php  $faculties->prepend('Select Faculty', ''); @endphp
            {!! Form::select('faculty_id',$faculties,'',['class'=>'form-control','required'=>'required','id'=>'faculty_id']) !!}<i></i>
        </div>
    </div>
</div>

<div class="subjects">


</div>
