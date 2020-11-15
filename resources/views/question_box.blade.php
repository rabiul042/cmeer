@extends('layouts.app')

@section('content')
<div class="container">


    <div class="row">

        @include('side_bar')

        <div class="col-md-9 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#7fc9f6; color: #FFFFFF;"><h3>Question Box</h3></div>

                <div class="panel-body">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif

                        <div class="col-md-12 col-md-offset-0" style="">

                            <h4><a href="question-add" class="btn btn-xm btn-primary" style="background-color:Red;">Add Question</a></h4>

                            <div class="portlet">
                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover datatable">
                                        <thead>
                                        <tr>

                                            <th width="100">#</th>
                                            <th>Registration No.</th>
                                            <th>Video</th>

                                            <th width="140">Action</th>
                                            
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($question_info as $key => $question)
                                            <tr>
                                                <td>{{++$key}}</td>
                                                <td>{{(isset($question->doctor_course_id))?$question->doctor_course_id:''}}</td>
                                                <td>{{(isset($question->videoname->name))?$question->videoname->name:''}}</td>
                                                <td>
                                                    <a href="view-answer/{{$question->id}}" class="btn btn-xs btn-primary" style="background-color:Green;">View Answer</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        

                                        </tbody>
                                    </table>
                                </div>
                            </div>



                </div>
            </div>
        </div>

    </div>

</div>
@endsection


@section('js')

    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $("body").on( "change", "[name='batch_id']", function() {
                var batch_id = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: '/batch-lecture',
                    dataType: 'HTML',
                    data: {batch_id : batch_id},
                    success: function( data ) {
                        $('.lecture').html(data);
                    }
                });
            })

        })
    </script>

@endsection