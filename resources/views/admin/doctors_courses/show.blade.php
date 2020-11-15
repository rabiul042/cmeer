<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" rel="stylesheet" type="text/css"/>
    <style>
        .heading h3 {
            font-weight: 700;
            font-size: 24px;
        }
        .heading p {
            line-height: 4px;
            font-size: 14px;
        }

        .admission_form {
            font-weight: 700;
            font-size: 18px;
            background: #bababa;
            border-radius: 20px;
        }

        .img_box {
            width: 169px;
            height: 169px;
            overflow: hidden;
            object-fit: cover;
            padding: 0 !important;
        }

        .img_box img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover;
        }

        table tr th, table tr td {
            padding: 1px 5px !important;
            font-size: 14px;
        }

        table th.heading {
            font-size: 18px;
            background: #bababa;
        }

        .enclosure table tr td,
        .diclare {
            font-size: 12px;
        }

        .footer_table {
            background: #f5f5f5;
        }

        .batch_table {
            background: #f5f5f5;
        }
    </style>
</head>
<body>

<section class="p-3">
    <div class="container">
        <div class="row">
            <div class="col-12 text-right">
                <button type="button" onclick="onPrintPage()" class="print_btn btn border px-1 py-0">
                    <img src=" {{ asset('print.png') }} " width="20" height="20" alt="" title="Print">
                </button>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-12 text-center d-flex justify-content-center heading">
                <div style="width:70px">
                    <img class="img-fluid w-100" src="{{asset('images/logo.png')}}" alt="">
                </div>
                <div class="pl-2">
                    <h3>Hypertension & Research Centre, Rangpur</h3>
                    <p>(A sister concern of Dr. Wasim - Waleda Bahumukhi Kallayan Fuoundation)</p>
                    <p>Holding No. 13/2, Hypertension Centre Lane, Jail Road, Dhap, Rangpur</p>
                    <p>Tel: 052153808; Mobile: +8801730448610</p>
                </div>
            </div>
            <div class="col-12">
                <div class="bg-dark text-white text-center">
                    <h5 class="py-1">Certificate Course on Hypertension</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-3">
        <div class="row">
            <div class="col-4 text-center">
            </div>
            <div class="col-4 px-0 text-center">
                <span class="py-2 px-4 admission_form">Admission Form</span>
            </div>
            <div class="col-4 text-center text-center">
                <table class="table table-bordered batch_table">
                    <tr>
                        <td>Date</td>
                        <td colspan="3">{{ $doctor_course->created_at->format('d M Y')??'' }}</td>
                    </tr>
                    <tr>
                        <td>Batch</td>
                        <td>{{ $doctor_course->batch->name??'' }}</td>
                        <td>Session</td>
                        <td>{{ $doctor_course->session->name??'' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row py-1 ml-0">
            <div class="img_box border" style="width: 169px">
                <img class="img-fluid" src=" {{ asset( $user->photo??'images/doc_male.jpg' ) }} " alt="">
            </div>
            <div class="" style="width: calc(100% - 169px)">
                <table class="table table-bordered w-100">
                    <tr>
                        <th width="140">Applicant's Name</th>
                        <td>{{ $user->name??'' }}</td>
                    </tr>
                    <tr>
                        <th>Father's Name</th>
                        <td>{{ $user->father_name??'' }}</td>
                    </tr>
                    <tr>
                        <th>Mother's Name</th>
                        <td>{{ $user->mother_name??'' }}</td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td>{{ $user->date_of_birth??'' }}</td>
                    </tr>
                    <tr>
                        <th>Medical College</th>
                        <td>{{ $user->medicalcolleges->name??'' }}</td>
                    </tr>
                    <tr>
                        <th>BMDC Reg. No.</th>
                        <td>{{ $user->bmdc_no??'' }}</td>
                    </tr>
                    <tr>
                        <th>NID</th>
                        <td>{{ $user->nid??'' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-6 pr-0">
                <table class="table table-bordered">
                    <tr>
                        <th width="120">Contact Mobile</th>
                        <td>{{ $user->mobile_number??'' }}</td>
                    </tr>
                    <tr>
                        <th>E-mail</th>
                        <td>{{ $user->email??'' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-6 pl-0">
                <table class="table table-bordered">
                    <tr>
                        <th width="140">Gender</th>
                        <td>{{ $user->gender??'' }}</td>
                    </tr>
                    <tr>
                        <th>Employment Status</th>
                        <td>{{ $user->job_description??'' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-6 pr-0">
                <table class="table table-bordered">
                    <tr>
                        <th class="heading" colspan="2">Present Address :</th>
                    </tr>
                    <tr>
                        <th width="60">Address</th>
                        <td>{{ $user->permanent_address??'' }}</td>
                    </tr>
                    <tr>
                        <th>Upazilla</th>
                        <td>{{ $user->permanent_upazila->name??'' }}</td>
                    </tr>
                    <tr>
                        <th>District</th>
                        <td>{{ $user->permanent_district->name??'' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-6 pl-0">
                <table class="table table-bordered">
                    <tr>
                        <th class="heading" colspan="2">Permanent Address :</th>
                    </tr>
                    <tr>
                        <th width="60">Address</th>
                        <td>{{ $user->present_address??'' }}</td>
                    </tr>
                    <tr>
                        <th>Upazilla</th>
                        <td>{{ $user->present_upazila->name??'' }}</td>
                    </tr>
                    <tr>
                        <th>District</th>
                        <td>{{ $user->present_district->name??'' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="heading" colspan="6">Educationnal : </th>
                        </tr>
                        <tr>
                            <th>Examination</th>
                            <th>Board/Isntitute</th>
                            <th>Result</th>
                            <th>Year</th>
                            <th>Roll</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->educations as $education)
                        <tr>
                            <td>{{ $education->exam }}</td>
                            <td>{{ $education->board }}</td>
                            <td>{{ $education->result }}</td>
                            <td>{{ $education->passing_year }}</td>
                            <td>{{ $education->roll }}</td>
                            <td>{{ $education->duration }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container">
        <p class="diclare">
            I declare, that the information provided in this form are correct, true and complete to the best of my knowledge and belief. If any information is found false, incorrect, incomplete or if any ineligibility is detected before or after the examination, any action can be taken against me by the Authority including cancellation of my candidature.
        </p>
    </div>

    <div class="container">
        <div class="px-3 enclosure">
            <table class="table table-borderless">
                <tr>
                    <th colspan="2">Enclosure :</th>
                </tr>
                <tr>
                    <td width="200">01. PP Size Photograph</td>
                    <td>: 2 Copy</td>
                    <td></td>
                </tr>
                <tr>
                    <td>02. NID Copy</td>
                    <td>: 1 Copy (Photo Copy)</td>
                    <td width="200" align="right">..........................................</td>
                </tr>
                <tr>
                    <td>03. MBBS/BDS Certified Copy</td>
                    <td>: 1 Copy (Photo Copy)</td>
                    <td align="right">Applicant's Signature</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="container footer_table pt-2">
        <table class="table table-borderless text-center">
            <tr>
                <td><i class="fa fa-envelope"></i> htn_rp@yahoo.com</td>
                <td><i class="fab fa-facebook"></i> www.facebook.com/HTN.centre</td>
                <td><i class="fa fa-globe"> www.htncr.com</td>
            </tr>
        </table>
    </div>

</section>

<!-- JavaScript Bundle with Popper.js -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js" integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD" crossorigin="anonymous"></script>
<script>
    const printBtn = document.querySelector('.print_btn')
    function onPrintPage(){
        printBtn.style.display = 'none'
        window.print()
        printBtn.style.display = ''
    }
</script>
</body>
</html>
