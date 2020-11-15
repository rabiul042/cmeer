@extends('admin.layouts.app')

@section('content')

    <div id="main" role="main">
        <div id="ribbon">
            <span class="ribbon-button-alignment">
                <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
                    <i class="fa fa-refresh"></i>
                </span>
            </span>
            <ol class="breadcrumb">
                <li>Home</li><li>Add Permissions</li>
            </ol>
        </div>

        <div id="content">

            <div class="row">
                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                    <h1 class="page-title txt-color-blueDark">
                        <i class="fa fa-edit fa-fw "></i>
                        Permissions<span>> Add Permissions</span>
                    </h1>
                </div>
            </div>

            @if(Session::has('message'))
                <div class="allert-message alert-success-message pgray  alert-lg" role="alert">
                    <p class=""> {{ Session::get('message') }}</p>
                </div>
            @endif


        <!-- widget grid -->
            <section id="widget-grid" class="">
                <article class="">
                    <div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">
                        <header>
                            <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                            <h2>Add Permissions </h2>
                        </header>
                        <div>
                            <div class="widget-body">
                {!! Form::model($permission, ['method' => 'PUT', 'route' => ['permissions.update', $permission->id]]) !!}




                                {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
                                {!! Form::text('name',  $permission->name, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                                <p class="help-block"></p>
                                @if($errors->has('name'))
                                    <p class="help-block">
                                        {{ $errors->first('name') }}
                                    </p>
                                @endif

                                <div class="form-group">
                                    <label for="name">Parent</label>
                                    @php $parent->prepend('Select Parent','0') @endphp
                                    {!! Form::select('parent_id', $parent, $permission->parent_id,['class'=>'form-control']) !!}
                                </div>




                {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
                </div>
            </div>
    </div>
    </article>



    </section>



    </div>


    </div>
@endsection

@section('js')

    <script src="{{ asset('js/jasny-bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('[name="role_id"]').change(function(){
                var id = $(this).val();
                if(id!=1){
                    $('.warehouse').removeClass('hidden');
                    $('[name="warehouse_id"]').attr('required', 'required');
                }else{
                    $('[name="warehouse_id"]').val('');
                    $('[name="warehouse_id"]').removeAttr('required');
                    $('.warehouse').addClass('hidden');
                }
            })
        })
    </script>

@endsection