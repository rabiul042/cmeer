@can('Doctors Course Edit')
<a href="{{ url('admin/doctors-courses/'.$doctors_courses_list->id.'/edit') }}" class="btn btn-xs btn-primary">Edit</a>
@endcan
@can('Doctors Course Delete')
{!! Form::open(array('route' => array('doctors-courses.destroy', $doctors_courses_list->id), 'method' => 'delete','style' => 'display:inline')) !!}
<button onclick="return confirm('Are You Sure ?')" class='btn btn-xs btn-danger' type="submit">Delete</button>
{!! Form::close() !!}
@endcan
<span class="btn btn-xs btn-primary" data-toggle='modal' data-target='#myModal_{{$doctors_courses_list->id}}'>Payment</span>
<a target="_blank" href="{{ url('admin/doctors-courses/'.$doctors_courses_list->id) }}" class="btn btn-xs btn-info">show</a>

<div class='modal fade' id='myModal_{{$doctors_courses_list->id}}' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
    <div class='modal-dialog' role='document'>
        <div class='modal-content modal-lg'>
            <div class='modal-header'>
                <h4 class='modal-title' id='myModalLabel'>Payment</h4>
            </div>
            <div class='modal-body'>
                <table class="table table-striped table-bordered table-hover datatable">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Payment By</th>
                        <th>Mobile / AC Name</th>
                        <th>Tr ID / AC No</th>
                        <th>Action</th>                      
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{(isset($doctors_courses_list->created_at) ? $doctors_courses_list->created_at : '')}}</td>
                        <td>{{(isset($doctors_courses_list->amount) ? $doctors_courses_list->amount : '')}}</td>
                        <td>{{(isset($doctors_courses_list->payment_by) ? $doctors_courses_list->payment_by : '')}}</td>
                        <td>{{(isset($doctors_courses_list->mobile_or_name) ? $doctors_courses_list->mobile_or_name : '')}}</td>
                        <td>{{(isset($doctors_courses_list->transaction_or_account	) ? $doctors_courses_list->transaction_or_account : '')}}</td>
                        <td>
                            {!! (isset($doctors_courses_list->status) 
                            ? 
                            $doctors_courses_list->payment_status == 'Requested' ? '<a href="'.url("admin/payment-confirm/".$doctors_courses_list->course_id."/".$doctors_courses_list->payment_id).'" class="btn btn-info">Confirm</a>' : $doctors_courses_list->payment_status
                            :
                            '') !!}
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-sm bg-red' data-dismiss='modal'>Close</button>
            </div>
        </div>
    </div>
</div>

