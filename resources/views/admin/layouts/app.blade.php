<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8"/>
    <title>@php echo (isset($title))?$title:'Tempore Admin' @endphp</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta name="MobileOptimized" content="320">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('assets/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/uniform/css/uniform.default.css') }}" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker.css') }}"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="{{ asset('assets/css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style-conquer.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/style-responsive.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/themes/default.css') }}" rel="stylesheet" type="text/css" id="style_color"/>
    <link rel="stylesheet" href="{{ asset('assets/css/jasny-bootstrap.min.css') }}">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('skin/vendor/ratings/star-rating-svg.css') }}">

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed">
<!-- BEGIN HEADER -->
<div class="header navbar  navbar-fixed-top">
    <!-- BEGIN TOP NAVIGATION BAR -->
    <div class="header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="{{ url('admin') }}">

                <img src="{{ url('logo.png') }}" width="45" height="45" >
                <!--
                <svg width="45px" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 620 621.89"><defs><style>.cls-1{fill:#fff;}.cls-2{fill:none;stroke:#fff;stroke-miterlimit:10;stroke-width:16px;}</style></defs><title>temporeLogoWhite</title><path class="cls-1" d="M675,259.49A280.23,280.23,0,0,0,445.92,655L400,678l-45.92-23a277.15,277.15,0,0,0,25.37-116.61A280.15,280.15,0,0,0,125,259.49L400,122Z" transform="translate(-90 -88.98)"/><polygon class="cls-2" points="612 461.94 310 612.94 8 461.94 8 159.94 310 8.94 612 159.94 612 461.94"/></svg>
                -->
            </a>
        </div>

        <ul class="nav navbar-nav pull-right">

            <li class="devider">
                &nbsp;
            </li>
            <!-- BEGIN USER LOGIN DROPDOWN -->
            <li class="dropdown user">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="fa fa-user"></i>
                    <span class="username">Admin </span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ url('admin/profile') }}"><i class="fa fa-user"></i> My Profile</a>
                    </li>

                    <li class="divider">
                    </li>
                    <li>
                        <a href="" title="Sign Out" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-key"></i> Log Out</a>
                        <form id="logout-form" action="{{ url('admin/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
            <!-- END USER LOGIN DROPDOWN -->
        </ul>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse">
            <!-- BEGIN SIDEBAR MENU -->
            <ul class="page-sidebar-menu">
                <li class="sidebar-toggler-wrapper">
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    <div class="sidebar-toggler">
                    </div>
                    <div class="clearfix">
                    </div>
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                </li>

                <li class="start @php echo (Request::segment(2)=='' )?'active':'' @endphp">
                    <a href="{{ url('admin') }}">
                        <i class="icon-home"></i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                @role('Administrator')
                <li class="@php echo (Request::segment(2)=='administrator')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="icon-users"></i><span class="title">Administrator</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">

                        <li class="@php echo (Request::segment(2)=='administrator' && Request::segment(3)=='')?'active':''  @endphp">
                            <a href="{{ url('admin/administrator') }}">Administrator List</a>
                        </li>

                        <li class="@php echo (Request::segment(2)=='administrator' && Request::segment(3)=='create')?'active':''  @endphp">
                            <a href="{{ action('Admin\AdministratorController@create') }}">Add Administrator</a>
                        </li>

                    </ul>
                </li>

                <li class="@php echo (Request::segment(2)=='roles')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-genderless"></i><span class="title">Roles</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@php echo (Request::segment(2)=='roles' && Request::segment(3)=='')?'active':''  @endphp">
                            <a href="{{ url('admin/roles') }}">Roles List</a>
                        </li>
                        <li class="@php echo (Request::segment(2)=='roles' && Request::segment(3)=='create')?'active':''  @endphp">
                            <a href="{{ action('Admin\RolesController@create') }}">Add Role</a>
                        </li>
                    </ul>
                </li>
                @endrole
               

                @can('Doctors')
                    <li class="@php echo (Request::segment(2)=='doctors')?'active':''  @endphp">
                        <a href="javascript:;">
                            <i class="fas fa-book"></i><span class="title">Doctors</span><span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">

                            <li class="@php echo (Request::segment(2)=='doctors' && Request::segment(3)=='')?'active':''  @endphp">
                                <a href="{{url('admin/doctors')}}">Doctors List</a>
                            </li>

                            @can('Doctor Add')
                                <li class="@php echo (Request::segment(2)=='doctors' && Request::segment(3)=='create')?'active':''  @endphp">
                                    <a href="{{ url('admin/doctors/create') }}">Doctor Add</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                

                @can('Doctors Courses')
                    <li class="@php echo (Request::segment(2)=='doctors-courses' || Request::segment(2)=='doctors-courses-trash' )?'active':''  @endphp">
                        <a href="javascript:;">
                            <i class="fas fa-book"></i><span class="title">Doctors Courses</span><span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="@php echo (Request::segment(2)=='doctors-courses' && Request::segment(3)=='')?'active':''  @endphp">
                                <a href="{{url('admin/doctors-courses')}}">Doctors Courses List</a>
                            </li>

                            <li class="@php echo (Request::segment(2)=='doctors-courses-trash' && Request::segment(3)=='')?'active':''  @endphp">
                                <a href="{{url('admin/doctors-courses-trash')}}">Doctors Courses Trash</a>
                            </li>

                            @can('Doctors Course Add')
                                <li class="@php echo (Request::segment(2)=='doctors-courses' && Request::segment(3)=='create')?'active':''  @endphp">
                                    <a href="{{ url('admin/doctors-courses/create') }}">Doctors Courses Add</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('Batch Schedule')
                <li class="@php echo (Request::segment(2)=='batches-schedules')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-book"></i><span class="title">Batch Schedules</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@php echo (Request::segment(2)=='batches-schedules' && Request::segment(3)=='')?'active':''  @endphp">
                            <a href="{{url('admin/batches-schedules')}}">Batch Schedules List</a>
                        </li>
                        @can('Batch Schedule Add')
                        <li class="@php echo (Request::segment(2)=='batches-schedules' && Request::segment(3)=='create')?'active':''  @endphp">
                            <a href="{{ url('admin/batches-schedules/create') }}">Batch Schedules Add</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan


                @can('Settings')
                <li class="@php echo (Request::segment(2)=='institutes' || Request::segment(2)=='courses' || Request::segment(2)=='sessions' || Request::segment(2)=='faculty' || Request::segment(2)=='subjects' || Request::segment(2)=='batch' || Request::segment(2)=='batch-discipline-fee')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-cogs"></i><span class="title">Settings</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        @can('Institutes')
                            <li class="@php echo (Request::segment(2)=='institutes')?'active':''  @endphp">
                                <a href="{{url('admin/institutes')}}"><i class="fas fa-institution"></i>  Institutes </a>
                            </li>
                        @endcan
                        @can('Courses')
                            <li class="@php echo (Request::segment(2)=='courses')?'active':''  @endphp">
                                <a href="{{url('admin/courses')}}"><i class="fas fa-institution"></i>  Courses </a>
                            </li>
                        @endcan
                        @can('Courses')
                            <li class="@php echo (Request::segment(2)=='sessions')?'active':''  @endphp">
                                <a href="{{url('admin/sessions')}}"><i class="fas fa-institution"></i>  Sessions</a>
                            </li>
                        @endcan
                        @can('Faculty')
                            <li class="@php echo (Request::segment(2)=='faculty')?'active':''  @endphp">
                                <a href="{{url('admin/faculty')}}"><i class="fas fa-institution"></i> Faculty</a>
                            </li>
                        @endcan
                        @can('Subject')
                            <li class="@php echo (Request::segment(2)=='subjects')?'active':''  @endphp">
                                <a href="{{url('admin/subjects')}}"><i class="fas fa-institution"></i> Discipline</a>
                            </li>
                        @endcan
                        @can('Batch')
                            <li class="@php echo (Request::segment(2)=='batch')?'active':''  @endphp">
                                <a href="{{url('admin/batch')}}"><i class="fas fa-institution"></i> Batch </a>
                            </li>

                            <!-- <li class="@php echo (Request::segment(2)=='batch')?'active':''  @endphp">
                                <a href="{{url('admin/print-batch-doctor-address')}}"><i class="fas fa-institution"></i> Print Batch Doctors Address</a>
                            </li> -->
                        @endcan
                        <!-- @can('Batch') -->
                        <!-- <li class="@php echo (Request::segment(2)=='batch-discipline-fee')?'active':''  @endphp">
                                <a href="{{url('admin/batch-discipline-fee')}}"><i class="fas fa-institution"></i> Batch Discipline Fee</a>
                        </li> -->
                        <!-- @endcan -->
                    </ul>
                </li>
                @endcan

                @can('Service Package')
                <li class="@php echo (Request::segment(2)=='service-packages')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-book"></i><span class="title">Service Packages</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@php echo (Request::segment(2)=='service-packages' && Request::segment(3)=='')?'active':''  @endphp">
                            <a href="{{url('admin/service-packages')}}">Service Packages List</a>
                        </li>
                        @can('Service Package Add')
                        <li class="@php echo (Request::segment(2)=='service-packages' && Request::segment(3)=='create')?'active':''  @endphp">
                            <a href="{{url('admin/service-packages/create')}}">Service Packages Create</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('Coming By')
                <li class="@php echo (Request::segment(2)=='coming-by')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-book"></i><span class="title">Coming By</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@php echo (Request::segment(2)=='coming-by' && Request::segment(3)=='')?'active':''  @endphp">
                            <a href="{{url('admin/coming-by')}}">Coming By List</a>
                        </li>
                        @can('Coming By Add')
                        <li class="@php echo (Request::segment(2)=='coming-by' && Request::segment(3)=='create')?'active':''  @endphp">
                            <a href="{{url('admin/coming-by/create')}}">Coming By Create</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('Questions')
                <li class="@php echo (Request::segment(2)=='mcq' || Request::segment(2)=='sba' || Request::segment(2)=='question-types')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-book"></i><span class="title">Questions</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        @can('MCQ Question')
                        <li class="@php echo (Request::segment(2)=='mcq' && Request::segment(3)=='')?'active':''  @endphp">
                            <a href="{{url('admin/mcq')}}">MCQ Question List</a>
                        </li>
                        @endcan
                        @can('SBA Question')
                        <li class="@php echo (Request::segment(2)=='sba' && Request::segment(3)=='')?'active':''  @endphp">
                            <a href="{{url('admin/sba')}}">SBA Question List</a>
                        </li>
                        @endcan
                        @can('Question Type')
                        <li class="@php echo (Request::segment(2)=='question-types' && Request::segment(3)=='')?'active':''  @endphp">
                            <a href="{{url('admin/question-types')}}">Question Type List</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('Exams')
                <li class="@php echo (Request::segment(2)=='exam' || Request::segment(2)=='upload-result' || Request::segment(2)=='view-result')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-book"></i><span class="title">Exam</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@php echo (Request::segment(2)=='exam' && Request::segment(3)=='')?'active':''  @endphp">
                            <a href="{{url('admin/exam')}}">Exam List</a>
                        </li>
                        @can('Exam Add')
                        <li class="@php echo (Request::segment(2)=='exam' && Request::segment(3)=='create')?'active':''  @endphp">
                            <a href="{{ action('Admin\ExamController@create') }}">Exam Add</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                <!-- @can('Exam Common Code')
                <li class="@php echo (Request::segment(2)=='online-exam-common-code')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-book"></i><span class="title">Exam Common Codes</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@php echo (Request::segment(2)=='online-exam-common-code' && Request::segment(3)=='')?'active':''  @endphp">
                            <a href="{{url('admin/online-exam-common-code')}}">Exam Common Code List</a>
                        </li>
                        @can('Exam Common Code Add')
                            <li class="@php echo (Request::segment(2)=='online-exam-common-code' && Request::segment(3)=='create')?'active':''  @endphp">
                                <a href="{{ action('Admin\OnlineExamCommonCodeController@create') }}">Exam Common Code Add</a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('Online Exam Links')
                    <li class="@php echo (Request::segment(2)=='online-exam-link')?'active':''  @endphp">
                        <a href="javascript:;">
                            <i class="fas fa-book"></i><span class="title">Online Exam Links</span><span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="@php echo (Request::segment(2)=='online-exam' && Request::segment(3)=='')?'active':''  @endphp">
                                <a href="{{url('admin/online-exam')}}">Online Exam</a>
                            </li>
                            @can('Online Exam Links Add')
                                <li class="@php echo (Request::segment(2)=='online-exam-link' && Request::segment(3)=='create')?'active':''  @endphp">
                                    <a href="{{ action('Admin\OnlineExamBatchController@create') }}">Online Exam Link Add</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan -->
                
                <!-- @can('Online Exam Links')
                <li class="@php echo (Request::segment(2)=='online-lecture-address' || Request::segment(2)=='online-lecture-link')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-cogs"></i><span class="title">Online Lectures</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        @can('Online Exam Links')
                            <li class="@php echo (Request::segment(2)=='online-lecture-address')?'active':''  @endphp">
                                <a href="{{url('admin/online-lecture-address')}}"><i class="fas fa-institution"></i>Lecture Address</a>
                            </li>
                        @endcan
                        @can('Online Exam Links')
                            <li class="@php echo (Request::segment(2)=='online-lecture-link')?'active':''  @endphp">
                                <a href="{{url('admin/online-lecture-link')}}"><i class="fas fa-institution"></i>Online Lecture Link </a>
                            </li>
                        @endcan
                        
                    </ul>
                </li>
                @endcan -->

                @can('Lecture Video Management')
                <li class="@php echo (Request::segment(2)=='online-exam' || Request::segment(2)=='online-exam-batch' || Request::segment(2)=='online-exam-link')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-cogs"></i><span class="title">Online Exams</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        @can('Lecture Video')
                            <li class="@php echo (Request::segment(2)=='online-exam')?'active':''  @endphp">
                                <a href="{{url('admin/online-exam')}}"><i class="fas fa-institution"></i>Online Exam</a>
                            </li>
                        @endcan
                        @can('Lecture Video Batch')
                            <li class="@php echo (Request::segment(2)=='online-exam-batch')?'active':''  @endphp">
                                <a href="{{url('admin/online-exam-batch')}}"><i class="fas fa-institution"></i>Online Exam Batch</a>
                            </li>
                        @endcan
                    </ul>
                </li>
                <!-- @endcan    -->

                @can('Lecture Video Management')
                <li class="@php echo (Request::segment(2)=='lecture-video' || Request::segment(2)=='lecture-video-batch' || Request::segment(2)=='lecture-video-link')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-cogs"></i><span class="title">Lecture Videos</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        @can('Lecture Video')
                            <li class="@php echo (Request::segment(2)=='lecture-video')?'active':''  @endphp">
                                <a href="{{url('admin/lecture-video')}}"><i class="fas fa-institution"></i>Lecture Video</a>
                            </li>
                        @endcan
                        @can('Lecture Video Batch')
                            <li class="@php echo (Request::segment(2)=='lecture-video-batch')?'active':''  @endphp">
                                <a href="{{url('admin/lecture-video-batch')}}"><i class="fas fa-institution"></i>Lecture Video Batch</a>
                            </li>
                        @endcan                        
                    </ul>
                </li>
                @endcan               

                {{-- @can('Lecture Sheet Management')
                <li class="@php echo (Request::segment(2)=='lecture' || Request::segment(2)=='lecture-sheet' || Request::segment(2)=='lecture-sheet-link' )?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-cogs"></i><span class="title">Lecture Sheets</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <!-- @can('Online Exam Links')
                            <li class="@php echo (Request::segment(2)=='lecture-sheet')?'active':''  @endphp">
                                <a href="{{url('admin/lecture-sheet')}}"><i class="fas fa-institution"></i>  Lecture Sheet List </a>
                            </li>
                            <li class="@php echo (Request::segment(2)=='lecture-sheet'  && Request::segment(3)=='create')?'active':''  @endphp">
                                <a href="{{url('admin/lecture-sheet/create')}}"><i class="fas fa-institution"></i>  Lecture Sheet Add </a>
                            </li>
                        @endcan -->
                        <!-- @can('Online Exam Links')
                            <li class="@php echo (Request::segment(2)=='lecture')?'active':''  @endphp">
                                <a href="{{url('admin/lecture')}}"><i class="fas fa-institution"></i>  Lecture Sheet </a>
                            </li>
                        @endcan -->
                        @can('Lecture Sheet')
                            <li class="@php echo (Request::segment(2)=='lecture-sheet')?'active':''  @endphp">
                                <a href="{{url('admin/lecture-sheet')}}"><i class="fas fa-institution"></i>  Lecture Sheet Article</a>
                            </li>
                        @endcan
                        @can('Lecture Sheet Link')
                            <li class="@php echo (Request::segment(2)=='lecture-sheet-link')?'active':''  @endphp">
                                <a href="{{url('admin/lecture-sheet-link')}}"><i class="fas fa-institution"></i>  Lecture Sheet Link </a>
                            </li>
                        @endcan
                        
                    </ul>
                </li>
                @endcan --}}

                @can('Topics')
                <li class="@php echo (Request::segment(2)=='topic')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-book"></i><span class="title">Class/Chapter</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@php echo (Request::segment(2)=='topic' && Request::segment(3)=='')?'active':''  @endphp">
                            <a href="{{url('admin/topic')}}">Class/Chapter List</a>
                        </li>
                        @can('Topic Add')
                        <li class="@php echo (Request::segment(2)=='topic' && Request::segment(3)=='create')?'active':''  @endphp">
                            <a href="{{ action('Admin\TopicController@create') }}">Class/Chapter Add</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('Teachers')
                <li class="@php echo (Request::segment(2)=='teacher')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-book"></i><span class="title">Teacher</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@php echo (Request::segment(2)=='teacher' && Request::segment(3)=='')?'active':''  @endphp">
                            <a href="{{url('admin/teacher')}}">Teacher List</a>
                        </li>
                        @can('Teacher Add')
                        <li class="@php echo (Request::segment(2)=='teacher' && Request::segment(3)=='create')?'active':''  @endphp">
                            <a href="{{ action('Admin\TeacherController@create') }}">Teacher Add</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('Room')
                <li class="@php echo (Request::segment(2)=='room')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-book"></i><span class="title">Rooms</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">                        
                        <li class="@php echo (Request::segment(2)=='room' && Request::segment(3)=='')?'active':''  @endphp">
                            <a href="{{url('admin/room')}}">Room List</a>
                        </li>                        
                        @can('Room Add')
                        <li class="@php echo (Request::segment(2)=='room' && Request::segment(3)=='create')?'active':''  @endphp">
                            <a href="{{ action('Admin\RoomController@create') }}">Room Add</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('Pages')
                <li class="@php echo (Request::segment(2)=='page')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-book"></i><span class="title">Pages</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@php echo (Request::segment(2)=='page' && Request::segment(3)=='')?'active':''  @endphp">
                            <a href="{{url('admin/page')}}">Pages List</a>
                        </li>
                        @can('Pages Add')
                            <li class="@php echo (Request::segment(2)=='page' && Request::segment(3)=='create')?'active':''  @endphp">
                                <a href="{{ action('Admin\PageController@create') }}">Page Add</a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                

                <li class="@php echo (Request::segment(2)=='notice')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-book"></i><span class="title">Notice</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@php echo (Request::segment(2)=='notice' && Request::segment(3)=='')?'active':''  @endphp">
                            <a href="{{url('admin/notice')}}">Notice List</a>
                        </li>
                        
                    </ul>
                </li>
                

                {{-- @can('Doctor Question')
                <li class="@php echo (Request::segment(2)=='doctors_quesions')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-book"></i><span class="title">Doctors Questions</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@php echo (Request::segment(2)=='doctors_quesions' && Request::segment(3)=='')?'active':''  @endphp">
                            <a href="{{url('admin/doctors-questions')}}">Doctors Questions List</a>
                        </li>
                        
                    </ul>
                </li>
                @endcan 

                @can('Doctor Complain')
                <li class="@php echo (Request::segment(2)=='doctor-complain-list')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-book"></i><span class="title">Doctor Complains</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@php echo (Request::segment(2)=='doctor-complain-list' && Request::segment(3)=='')?'active':''  @endphp">
                            <a href="{{url('admin/doctor-complain-list')}}">Doctor Complain List</a>
                        </li>
                        
                    </ul>
                </li>
                @endcan --}}


                @can('Report')
                <li class="@php echo (Request::segment(2)=='reports')?'active':''  @endphp">
                    <a href="javascript:;">
                        <i class="fas fa-book"></i><span class="title">Reports</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="@php echo (Request::segment(2)=='reports' && Request::segment(3)=='')?'active':''  @endphp">
                            <a href="{{url('admin/payment')}}">Payment List</a>
                        </li>
                        
                    </ul>
                </li>
                @endcan

                
            </ul>
            <!-- END SIDEBAR MENU -->
        </div>
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Modal title</h4>
                        </div>
                        <div class="modal-body">
                            Widget settings form goes here
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success">Save changes</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            @yield('content')


        </div>

    </div>
    <!-- END CONTENT -->
</div>


<div class="footer">
    <div class="footer-inner">
        {{ date('Y') }} &copy; CMEER
    </div>
    <div class="footer-tools">
		<span class="go-top">
		<i class="fa fa-angle-up"></i>
		</span>
    </div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<script src="{{ asset('assets/plugins/jquery-1.11.0.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/plugins/jquery-migrate-1.2.1.min.js') }}" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>


<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->

<script type="text/javascript" src="//cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('assets/scripts/app.js') }}"></script>


@yield('js')
<script>
    $(document).ready(function() {
        // initiate layout and plugins
        App.init();

    });
</script>

</body>
<!-- END BODY -->
</html>
