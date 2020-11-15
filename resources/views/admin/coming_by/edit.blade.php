@extends('admin.layouts.app')

@section('content')

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i><a href="{{ url('/admin') }}">Home</a></i>
            </li>
            <?php
            $urls='';
            foreach($breadcrumb as $key=>$value){ $urls .= $value.'/';
                echo '<li> <i class="fa fa-angle-right"></i> <a href="'.url('/').substr_replace($urls, "", -1).'"> '.$value.' </a></li>';
            }
            ?>
        </ul>
    </div>

    @if(Session::has('message'))
        <div class="alert {{ (Session::get('class'))?Session::get('class'):'alert-success' }}" role="alert">
            <p> {{ Session::get('message') }}</p>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i><?php echo $module_name;?> Edit
                    </div>
                </div>
                <div>
                    <?php
                    //echo '<pre>';
                    //print_r($institute);
                    ?>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                        {!! Form::open(['action'=>['Admin\ComingByController@update',$coming_by->id],'method'=>'PUT','files'=>true,'class'=>'form-horizontal']) !!}
                        <div class="form-body">

                                <div class="form-group">
                                    <label class="col-md-1 control-label">Name <i class="fa fa-asterisk ipd-star"></i></label>
                                    <div class="col-md-3">
                                        <div class="input-icon right">
                                            <input type="text" name="name" required value="{{ $coming_by->name?$coming_by->name:'' }}" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!--
                                <div class="form-group">
                                    <label class="col-md-1 control-label">Select Status <i class="fa fa-asterisk ipd-star"></i></label>
                                    <div class="col-md-3">
                                        {!! Form::select('status', ['1' => 'Active','0' => 'InActive'], $coming_by->status,['class'=>'form-control']) !!}<i></i>
                                    </div>
                                </div>
                                -->
                    </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-1 col-md-9">
                                    <button type="submit" class="btn btn-info"><?php echo $submit_value;?></button>
                                    <a href="{{ url('admin/coming-by') }}" class="btn btn-default">Cancel</a>
                                </div>
                            </div>
                        </div>
                       {!! Form::close() !!}
                    <!-- END FORM-->
                </div>
            </div>

        </div>
    </div>



@endsection

@section('js')

    <script type="text/javascript">
        // DO NOT REMOVE : GLOBAL FUNCTIONS!
        $(document).ready(function() {

               // $('.select2').select2();

        })
    </script>




@endsection