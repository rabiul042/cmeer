@extends('layouts.app')

@section('content')
<div class="container">


    <div class="row">

        @include('side_bar')

        <div class="col-md-9 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#7fc9f6; color: #FFFFFF;"><h3>View Reply</h3></div>

                <div class="panel-body">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif

                        <div class="col-md-12 col-md-offset-0" style="">

                            <div class="portlet">
                                <div class="portlet-body">
                                    
                                    @foreach($complain_details as $key => $complain)
                                        <div class="col-md-12" style=" padding:10px; margin: 2px;
                                        background-color:{{($complain->user_id!=0)?'#FFFFFF':'#E9E9E9'}};">
                                            {{($complain->user_id!=0)?'Replied':'My Complain'}} : 
                                            @php echo strip_tags($complain->message); @endphp
                                        </div>
                                    @endforeach
                                    
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12" style="margin-top: 20px;">
                            <hr>
                            <!-- <h4>Type Complain</h4> -->
                            {!! Form::open(['url'=>['complain-again'],'method'=>'post','files'=>true,'class'=>'form-horizontal']) !!}
                            <div class="form-body">
                                
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="input-icon right">
                                            <textarea name="description" required></textarea>
                                            <input type="hidden" name="complain_id" value="{{$complain_id}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-0 col-md-9">
                                            <button type="submit" class="btn btn-info">Submit</button>
                                        </div>
                                    </div>
                                </div>
                        {!! Form::close() !!}
                        </div>
            </div>
        </div>

    </div>

</div>
@endsection


@section('js')

    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

    <script type="text/javascript">
        // DO NOT REMOVE : GLOBAL FUNCTIONS!
        $(document).ready(function() {
            CKEDITOR.replace( 'description' );
            // $('.select2').select2();
        })
    </script>
    <!-- data -->
@endsection