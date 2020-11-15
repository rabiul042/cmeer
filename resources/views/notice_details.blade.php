@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">

        @include('side_bar')

        <div class="col-md-9 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#7fc9f6; color: #FFFFFF;"><h3>Notice Details</h3></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                        <div class="col-md-12">
                            <div class="portlet">
                                <div class="portlet-body">
                                    <h3><b>{{$notices->title}}</b></h3>

                                    <?php 
                                        if ($notices->attachment) {
                                            echo "<a href='".url($notices->attachment)."' target='_blank'>View Attachment</a>"; 
                                        } 

                                        if ($notices->type=='I'){
                                            echo "<h5>Notice type : For me</h5>"; 
                                        } elseif ($notices->type=='B') {
                                            echo "<h5>Notice type : Batch</h5>";
                                        } else {
                                            echo "<h5>Notice type : All</h5>";
                                        }

                                        if ($notices->type=='B'){
                                            echo "<h5>Year : ".$notices->year."</h5>";
                                            echo "<h5>Session : ".$notices->sessionname->name."</h5>";
                                            echo "<h5>Institute : ".$notices->institutename->name."</h5>";
                                            echo "<h5>Course : ".$notices->coursename->name."</h5>";
                                            echo "<h5>Batch : ".$notices->batchname->name."</h5>";
                                        }

                                    ?>
                                    <hr>
                                    <h4 style="color:Orange;">Notice : </h4>
                                    <?php echo $notices->notice; ?>

                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>

    </div>


</div>
@endsection
