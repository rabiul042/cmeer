@extends('layouts.app')
@section('content')
    <style>
        .page-breadcrumb {
            display: inline-block;
            float: left;
            padding: 8px;
            margin: 0;
            list-style: none;
        }
        .page-breadcrumb > li {
            display: inline-block;
        }
        .page-breadcrumb > li > a,
        .page-breadcrumb > li > span {
            color: #666;
            font-size: 14px;
            text-shadow: none;
        }
        .page-breadcrumb > li > i {
            color: #999;
            font-size: 14px;
            text-shadow: none;
        }
        .page-breadcrumb > li > i[class^="icon-"],
        .page-breadcrumb > li > i[class*="icon-"] {
            color: gray;
        }
    </style>

    <div class="container">


        <div class="row">

            @include('side_bar')

            <div class="col-md-9 col-md-offset-0">
                <div class="panel panel-default pt-2">
                    <div class="panel_box w-100 bg-white rounded shadow-sm">
                        <div class="header text-center py-3">
                            <h2 class="h2 brand_color">{{ 'Online Exam' }}</h2>
                        </div>
                    </div>

                    <div class="panel-body">
                        @if(Session::has('message'))
                            <div class="alert {{ (Session::get('class'))?Session::get('class'):'alert-success' }}" role="alert">
                                <p> {!! Session::get('message') !!} </p>
                            </div>
                        @endif


                        <div class="col-md-12">
                            <div class="portlet">
                                <div class="portlet-body">

                                    @if(Request::segment(1)=='doctor-course-online-exam')
                                        {{--@if(isset($online_exam_batch))
                                            <div class="row mx-0">

                                                <div class="col p-0 pt-3">
                                                    <table class="bg-white table text-center table-striped table-bordered rounded p-1 table-hover datatable">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>Date</th>
                                                                <th>Online Exam Links</th>
                                                                <th>Online Results & Answer Details</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($online_exam_batch as $k => $link)
                                                            <tr>
                                                                <td class="pt-3">{{ ++$k }}</td>
                                                                <td class="pt-3">20 Sep 2020</td>
                                                                <td>
                                                                    <a href="{{ 'https://banglamedexam.com/user-login-sif?'.'name='.$doctor_course->doctor->name.'&email='.$doctor_course->reg_no.'&bmdc='.$doctor_course->doctor->bmdc_no.'&phone='.$doctor_course->doctor->mobile_number.'&exam_comm_code='.$link->exam_comm_code.'&topic_code='."0" }}" target="_blank" class="btn btn-sm btn-primary">{{ $link->exam_comm_code }}</a>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ "https://banglamedexam.com/history_sif.php?reg_no=".$doctor_course->reg_no }}" target="_blank" class="btn btn-sm btn-success">Online Results & Answer Details</a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="row mx-0">
                                                <div class="col-12">
                                                    <div class="text-center">
                                                        <style>
                                                            .pagination_box .pagination li {padding: 3px 5px; margin: 1px; border: 1px solid #707070;cursor: pointer; background: #fff !important;}
                                                        </style>
                                                        <div class="w-100 pagination_box pt-2 pb-4">
                                                            {{ $online_exam_batch->links() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @endif--}}

                                        @if(isset($exam_batch))

                                                <div class="row mx-0">

                                                    <div class="col p-0 pt-3">
                                                        <table class="bg-white table text-center table-striped table-bordered rounded p-1 table-hover datatable">
                                                            <thead>
                                                                <tr>
                                                                    <th>SL</th>
                                                                    <th>Date</th>
                                                                    <th>Exam Links</th>
                                                                    <th>Results & Answer Details</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($exam_batch as $k => $link)
                                                                <tr>
                                                                    <td class="pt-3">{{ ++$k }}</td>
                                                                    <td class="pt-3">20 Sep 2020</td>
                                                                    <td >
                                                                        <a href="{{ url('doctor-course-exam/'.$doctor_course->id.'/'.$link->id) }}" target="_self" class="btn btn-sm  btn-primary {{ ( \App\DoctorExam::where(['doctor_course_id'=>$doctor_course->id,'exam_id'=>$link->id])->first() && ( \App\DoctorExam::where(['doctor_course_id'=>$doctor_course->id,'exam_id'=>$link->id])->value('status') == "Completed" ) ? 'btn-info' : 'btn-success' )}}" onclick="return confirm('STEPS FOR EXAM : \n 1. Start now বক্স এ click করার পরপরই আপনার পরীক্ষা শুরু হয়ে যাবে। \n 2. প্রশ্ন MCQ type হলে প্রতিটি অপশন এর বিপরীতে T এবং F বৃত্ত রয়েছে। আপনি True যুক্তিযুক্ত মনে করলে T বৃত্ত অথবা False যুক্তিযুক্ত মনে করলে F বৃত্ত click করবেন। T বৃত্ত click করার পর পরিবর্তন করতে চাইলে F বৃত্ত click করার সুযোগ রয়েছে। (Vice versa). \n 3. প্রশ্ন SBA Type হলে যেকোনো একটি বৃত্ত click করুন। বৃত্ত পরিবর্তন করার সুযোগ রয়েছে। \n 4. পরবর্তী প্রশ্ন পেতে চাইলে Next বক্স এ click করুন। কোন প্রশ্ন এই মুহূর্তে answer না করে পরবর্তীতে আবার প্রশ্ন টি পেতে চাইলে TRY LATER বক্স এ click করুন। সিরিয়ালের শেষ প্রশ্নটি answer করার পর TRY LATER করে আসা প্রশ্ন গুলো answer করার সুযোগ পাবেন। \n উদাহরণস্বরূপ: 50 টি প্রশ্নের পরীক্ষায় আপনি যদি 7,10,15,25,32 নং প্রশ্ন TRY LATER করে থাকেন তাহলে সর্বশেষ 50 নং প্রশ্নটি answer করার পর পুনরায় 7,10,15,25,32 নং প্রশ্নগুলো answer করার সুযোগ পাবেন। \n 5. কোন প্রশ্ন এখন বা পরবর্তীতেও answer করার জন্য পেতে না চাইলে Next বক্স এ click করুন। এক্ষেত্রে প্রশ্নটি কাউন্ট হয়ে যাবে। \n 6. পরীক্ষা শেষ হলে Submit বক্স এ click করুন। \n 7. সময়ের দিকে খেয়াল রাখুন, নির্ধারিত সময়ের পর পরীক্ষাটি auto-submit হয়ে যাবে। \n 8. পরীক্ষা দেওয়ার পর পুরো প্রশ্নটিই আপনার উত্তর সহ আপনার প্রোফাইলে থাকবে। আপনি চাইলে পরবর্তীতে যেকোনো সময় এটি Answer details এ click করলে দেখতে পারবেন। \n 9. ব্যবহৃত ডিভাইসে (ল্যাপটপ, ট্যাবলেট, স্মার্ট ফোন) এ যথেষ্ট চার্জ করে রাখবেন যাতে পরীক্ষার পুরো সময়টিতে কোনো ব্যাঘাত না ঘটে। পরীক্ষা চলাকালীন সময়ে ব্যবহৃত ডিভাইসে কোন কল আদান-প্রদানে বিরত থাকুন। ইন্টারনেট কানেকশন নিশ্চিত রাখুন। একই সাথে একাধিক ডিভাইসে লগইন করা থেকে বিরত থাকুন।')" >{{ $link->name }}</a>
                                                                    </td>
                                                                    <td >
                                                                        <a href="{{ url('course-exam-result/'.$doctor_course->id.'/'.$link->id) }}" target="_self" class="btn btn-sm btn-info">Results & Answer Details</a>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>

                                                <div class="row mx-0">
                                                    <div class="col-12">
                                                        <div class="text-center">
                                                            <style>
                                                                .pagination_box .pagination li {padding: 3px 5px; margin: 1px; border: 1px solid #707070;cursor: pointer; background: #fff !important;}
                                                            </style>
                                                            <div class="w-100 pagination_box pt-2 pb-4">
                                                                {{ $exam_batch->links() }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif
                                    @elseif(Request::segment(1)=='online-exam')
                                        <div class="row mx-0">
                                            @foreach($doctor_courses as $doctor_course)
                                                <div class="col-md-6 p-1">
                                                    <a title="{{ $doctor_course->course->name.' : '.$doctor_course->batch->name }}" class="w-100 bg-white px-3 py-4 border rounded-lg" href="{{url('doctor-course-online-exam/'.$doctor_course->id)}}">
                                                        <h6 class="p text-black-50" >{{ $doctor_course->course->name.' : '.$doctor_course->batch->name }}</h6>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>


    </div>
@endsection