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
                        @can('Room Add')
                        <a href="{{url('admin/room/create')}}"> <i class="fa fa-plus"></i> </a>
                        @endcan
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
                            <th>ID</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Floor</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($rooms as $room)
                            <tr>
                                <td>{{ $room->id }}</td>
                                <td>{{ $room->room_name }}</td>
                                <td>{{ $room->Location }}</td>
                                <td>{{ $room->floor }}</td>
                                <td>{{ $room->capacity }}</td>
                                <td>{{ ($room->status==1)?'Active':'InActive' }}</td>
                                <td>
                                    @can('Room Edit')
                                    <a href="{{ url('admin/room/'.$room->id.'/edit') }}" class="btn btn-xs btn-primary">Edit</a>
                                    @endcan
                                    @can('Room Delete')
                                    {!! Form::open(array('route' => array('room.destroy', $room->id), 'method' => 'delete','style' => 'display:inline')) !!}
                                    <button onclick="return confirm('Are You Sure ?')" class='btn btn-xs btn-danger' type="submit">Delete</button>
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
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
                    { "searchable": true, "targets": 5 },
                    { "orderable": true, "targets": 5 }
                ]
            })
        })
    </script>

@endsection