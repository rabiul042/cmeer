@extends('admin.layouts.app')

@section('content')

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i><a href="{{ url('/') }}">Home</a><i class="fa fa-angle-right"></i>
            </li>
            <?php
            $urls='';
            foreach($breadcrumb as $key=>$value){ $urls .= $value.'/';
                echo '<li> <i class="fa fa-angle-right"></i> <a href="'.url('/').substr_replace($urls, "", -1).'">'.$value.'</a> </li>';
            }
            ?>
        </ul>
    </div>

    @if(Session::has('message'))
        <div class="alert alert-success" role="alert">
            <p> {{ Session::get('message') }}</p>
        </div>
    @endif


    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i><?php echo $module_name;?> List
                    </div>
                </div>
                <div>
                    <div class="caption">

                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover datatable">
                        <thead>
                        <tr>
                            <th width="100">#</th>
                            <th>Doctor</th>
                            <th>BMDC No</th>
                            <th>Mobile</th>
                            <th>Unread Complains</th>
                            <th width="140">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($doctor_complain_list as $key => $doctor_complain)
                                @if(isset($doctor_complain->doctor->name))
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$doctor_complain->doctor->name.' ( '.$doctor_complain->doctor->id.' ) ' }}</td>
                                    <td>{{$doctor_complain->doctor->bmdc_no }}</td>
                                    <td>{{$doctor_complain->doctor->mobile_number }}</td>
                                    <td>{{$doctor_complain->doctor_complains_replies->where('is_read','No')->where('user_id','0')->count() }}</td>                                    
                                    <td>
                                        <a href="view-complain/{{$doctor_complain->id}}" class="btn btn-xs btn-primary">View Complain</a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script type="text/javascript">
        // DO NOT REMOVE : GLOBAL FUNCTIONS!
        $(document).ready(function() {
            $('.datatable').DataTable({
                responsive: true,
                "columnDefs": [
                    { "searchable": false, "targets": 5 },
                    { "orderable": false, "targets": 5 }
                ]
            })
        })
    </script>

@endsection
