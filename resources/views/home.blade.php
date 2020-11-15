@extends('layouts.app')
@section('content')
<!-- ================= Banner Part Start ================= -->
<section id="banner_part">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-8 col-lg-7 order-lg-0 order-1">
                <!-- Carousel Start -->
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators mb-2">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/banner-1.webp')}}" class="d-block w-100" alt="banner-1">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/banner-2.webp')}}" class="d-block w-100" alt="banner-2">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/banner-3.webp')}}" class="d-block w-100" alt="banner-3">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/banner-4.webp')}}" class="d-block w-100" alt="banner-4">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/banner-5.webp')}}" class="d-block w-100" alt="banner-5">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <!-- Carousel End -->
            </div>
            <div class="col-xl-4 col-lg-5 order-lg-1 order-0 login_register_body">
                @guest
                <!-- Form Start -->
                <div id="log_part" class="">
                    <div class="form-box shadow-sm border-top border-bottom border-right border-left">
                        <div class="button-box">
                            <div id="btn"></div>
                            <button type="button" class="toggle-btn login_register_click" onclick="login()"
                                action="">Log In</button>
                            <!-- <button type="button" class="toggle-btn login_register_click" -->
                                <!-- onclick="register()">Register</button> -->
                        </div>
                        <form method="POST" action="{{ route('login') }}" id="login" class="input-group">
                            {{ csrf_field() }}
                            <input type="email" class="input-field" name="email" placeholder="Email"
                                value="{{ old('email') }}" required>
                            <input type="password" class="input-field password-field" name="password"
                                placeholder="Password" required>
                            <i toggle=".password-field" class="fa fa-fw fa-eye field-icon toggle-password"></i>
                            <a href="{{url('password/reset')}}" class="forgot_text btn-link">Forgot password?</a>
                            <input type="checkbox" class="check-box"><span>Remember Me</span>
                            <button type="submit" class="submit-btn">Submit</button>
                            <label class="account-txt">Don't have an Account ?</label>
                            <a href="{{ url('register-first-step') }}" class="register-btn">Register Now</a>
                        </form>
                        <form method="POST" action="{{ route('register-post') }}" id="register" class="input-group">
                            {{ csrf_field() }}
                            <input type="text" id="name" class="input-field" placeholder="Full Name" name="name"
                                value="{{ old('name') }}" required>
                            <input type="email" id="email" class="input-field" placeholder="E-mail" name="email"
                                value="{{ old('email') }}" required>
                            <input type="text" id="phone_number" class="input-field" placeholder="Mobile Number"
                                name="mobile_number" value="{{ old('mobile_number') }}" required>
                            <input type="password" id="password" class="input-field password-field-r"
                                placeholder="Password" name="password" required>
                            <i toggle=".password-field-r" class="fa fa-fw fa-eye field-icon toggle-password-r"></i>
                            <input id="password-confirm" type="password" class="input-field password-field-r"
                                placeholder="Confirm Password" name="password_confirmation" required>
                            <button type="submit" class="submit-btn">Submit</button>
                        </form>
                    </div>
                </div>
                <!-- Form End -->
                @else
                <!--Notice Board Start-->
                <div id="log_part" class="">
                    <div class="form-box shadow-sm border-top border-bottom border-right border-left overflow-auto">
                        <div class="panel-default">
                            <div class="panel-heading p-2 text-center"
                            style="background-color: #44ca75; color: #FFFFFF;">
                            <h3>Notice Board</h3>
                        </div>
                    </div>
                </div>
                <!--Notice Board End-->
                @endguest
            </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= Banner Part End ================= -->



<div id="course" style="transform: translateY(-80px);"></div>
<!-- ================= Course Part Start ================= -->
<section id="course_part">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h2>Our Courses</h2>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-2 g-lg-3">

            <div class="col item item-1">
                <a href="#" class="card">
                    <div class="card-body">
                        <h5>Refresher's Course</h5>
                        <p>Learn More<i class="far fa-arrow-alt-circle-right"></i></p>
                    </div>
                </a>
            </div>

            <div class="col item item-1">
                <a href="#" class="card">
                    <div class="card-body">
                        <h5>Refresher's Course</h5>
                        <p>Learn More<i class="far fa-arrow-alt-circle-right"></i></p>
                    </div>
                </a>
            </div>

            <div class="col item item-1">
                <a href="#" class="card">
                    <div class="card-body">
                        <h5>Refresher's Course</h5>
                        <p>Learn More<i class="far fa-arrow-alt-circle-right"></i></p>
                    </div>
                </a>
            </div>

        </div>
    </div>
</section>

<!-- ================= Course Part End ================= -->



<div id="gallery" style="transform: translateY(-80px);"></div>
<!-- ================= Gallery Part Start ================= -->
<section id="gallery_part">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="header text-center">
                    <h2>Photo Gallery</h2>
                </div>
            </div>
        </div>

        <div class="body row row-cols-lg-4 row-cols-sm-3 row-cols-2 g-0">
            @for($i=1; $i<=8; $i++) <div class="col border">
                <div class="img">
                    <img class="img-fluid w-100" src="{{ asset('images/gallery-'.$i.'.jpg')}}" alt="gallery-{{$i}}">
                    <div class="overly">
                        <a class="venobox" data-gall="gallery01" href="{{ asset('images/gallery-'.$i.'.jpg')}}">
                            <i class="fa fa-search-plus"></i>
                        </a>
                    </div>
                </div>
        </div>
        @endfor

    </div>
    </div>
</section>

<!-- ================= Gallery Part End ================= -->



<div id="testimonial" style="transform: translateY(-80px);"></div>
<!-- ================= Testimonial Part Start ================= -->
<section id="testimonial_part">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="header text-center">
                    <h2>Testimonial</h2>
                </div>
            </div>
        </div>

        <div class="row testimonial_slider text-left">

            <div class="item p-2">
                <div class="col-12 card">
                    <div class="card-body border rounded-lg">
                        <div class="img">
                            <img class="img-fluid w-100" src="{{asset('images/testimonial-1.png')}}" alt="testimonial">
                        </div>
                        <p style="text-align: justify;  min-height: 100px;">
                            This might be the best charitable and non-profit institution that 
                            dealing with a large number of hypertensive patients in Bangladesh.
                        </p>
                        <h5>- Mostofa Alam Bony</h5>
                    </div>
                </div>
            </div>
            <div class="item p-2">
                <div class="col-12 card">
                    <div class="card-body border rounded-lg">
                        <div class="img">
                            <img class="img-fluid w-100" src="{{asset('images/testimonial-2.png')}}" alt="testimonial">
                        </div>
                        <p style="text-align: justify;  min-height: 100px;">
                            <br />
                            Great service !!!
                            <br />
                            Highly recommended.......
                        </p>
                        <h5>- Moniruzzaman Monir</h5>
                    </div>
                </div>
            </div>
            <div class="item p-2">
                <div class="col-12 card">
                    <div class="card-body border rounded-lg">
                        <div class="img">
                            <img class="img-fluid w-100" src="{{asset('images/testimonial-3.png')}}" alt="testimonial">
                        </div>
                        <p style="text-align: justify;  min-height: 100px;">
                            Thanks to Hypertension &amp; Research Center for creating public awareness about hypertension and diabetes,
                            providing low cost medical services for these diseases.
                        </p>
                        <h5>- Jahangir Alam</h5>
                    </div>
                </div>
            </div>
            <div class="item p-2">
                <div class="col-12 card">
                    <div class="card-body border rounded-lg">
                        <div class="img">
                            <img class="img-fluid w-100" src="{{asset('images/testimonial-4.png')}}" alt="testimonial">
                        </div>
                        <p style="text-align: justify; min-height: 100px;">
                        <br />
                        I wish successful journey of Hyper Tension Research Centre, Rangpur</p>
                        <h5>- Md Mosaddek Hossain Limon</h5>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= Testimonial Part End ================= -->


<div id="faq" style="transform: translateY(-80px);"></div>
<!-- ================= FAQ Part Start ================= -->
<section id="faq_part">
    <div class="container">
        <div class="header text-center">
            <h2>F A Q</h2>
        </div>
        <div class="row">
            <div class="col">

                <div id="accordion" class="faq_body">

                    <div class="card">
                        <div class="card-header bg-white" id="heading-1">
                            <a href="" data-toggle="collapse" data-target="#collapse-1"
                                aria-expanded="true" aria-controls="collapse-1">
                                1. What is online registration process?
                            </a>
                        </div>

                        <div id="collapse-1" class="collapse show" aria-labelledby="heading-1" data-parent="#accordion">
                            <div class="card-body bg-white">
                                <p> Click on the 'Register' button</p>
                                <p> Provide your name, mobile number, email address and a password of at least 6
                                    digit.</p>
                                <p> Finaly Click 'Submit' button.</p>
                                <p> Note : Your email address will be your user ID.</p>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-white" id="heading-2">
                            <a href="" class="mix_solve" data-toggle="collapse" data-target="#collapse-2"
                                aria-expanded="true" aria-controls="collapse-2">
                                2. What is login process?
                            </a>
                        </div>

                        <div id="collapse-2" class="collapse" aria-labelledby="heading-2" data-parent="#accordion">
                            <div class="card-body bg-white">
                                <p> Please Go to 'Login' form</p>
                                <p> Provide your registered email and password</p>
                                <p> Click 'Submit' button to login</p>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</section>

<!-- ================= FAQ Part End ================= -->


<div id="about" style="transform: translateY(-80px);"></div>
<!-- ================= About Part Start ================= -->
<section id="about_part">
    <div class="container">
        <div class="header text-center">
            <h2>About Us</h2>
        </div>
        <div class="row">
            <div class="col">
                <div class="text card bg-white border-0">

                    <h4>Preface :</h4>
                    <p>
                        Hypertension and Research Centre, Rangpur is a sister concern of Dr. Wasim-waleda Bahumukhi Kallayan Foundation was established in 14 November 2008 with the aim of improvement of public consciousness on risk factor, morbidity and mortality of Hypertension as a part of a great and services of humanity. Hypertension Kills nearly 8 million people every year, worldwide and nearly 1.5 million people each year in the South-East Asia (SEA) Region. Approximately one third of the adult population in the SEA Region has high blood pressure. Prevalence of hypertension is 20-25% among adult population in Bangladesh. It is one of the 10 leading reported causes of death and about 4.0% deaths are due to hypertension and/or complication of hypertension in Bangladesh.
                    </p>

                    <h4>Establishment :</h4>
                    <p>
                        Hypertension and Research Centre, Rangpur the nonprofitable institution established in 14 November 2008. After establishment it is providing health services with minimum cost to the Hypertensive patients.
                    </p>

                    <h4>Objectives :</h4>
                    <p>
                         General objectives <br />
                        •Comprehensive care of Hypertensive patient. <br />
                        •To conduct medical research on Hypertension and its complications. <br />
                        •Promotion of mass awareness on Hypertension. <br /><br />

                        Specific objective <br /> 
                        1.Identification of pre Hypertensive and Hypertensive individuals. <br /> 
                        2.To provide step wise medical consultation by senior medical officer, consultant and chief consultant. <br /> 
                        3.Free medical camp for all classes of people in remote areas. <br /> 
                        4.To provide selective investigation facilities at a minimum cost to all registered patients. <br /> 
                        5.Maintain the medical confidentiality. <br /> 
                        6.Run all medical Research through systematic way at a regular interval. <br /> 
                        7.Article publication on the basis of research. <br /> 
                    </p>
                    
                    <h4>Government Approval :</h4>
                    <p>
                        • Registration under ministry of social welfare. <br /> 
                        • Registration under Directorate General of Health Services (DGHS). <br /> 
                        • Permission from ministry of Health and family welfare. <br /> 
                        • Registration under city corporation Rangpur ,Bangladesh  <br /> 
                        • Copy write, instruction & prescription Book. <br /> 
                        • Copy write, Hypertension Berta. <br /> 
                        • Fire license. <br /> 
                        • Trade license. <br /> 
                        • Lab license. <br /> 
                        • X-ray license. <br /> 
                        • TLD license. <br />  <br /> 
                    </p>
                    
                    <h4>Subscription fee :</h4>
                    <p>
                        Registration fee : 50/- <br /> 
                        Subsequent Follow up : 40/-
                    </p>

                    <h4>Flow chart: ( Patient registration & providing treatment process) :</h4>
                    
                    <p>
                        Registration <br /> 
                        ↓ <br /> 
                        Information, Advice, treatment & Copy write book <br /> 
                        ↓ <br /> 
                        Personal Data fill-up <br /> 
                        ↓ <br /> 
                        Take patient photo <br /> 
                        ↓ <br /> 
                        Counseling ( about Hypertension and its complication ) <br /> 
                        ↓ <br /> 
                        Checkup Senior Medical officer. <br /> 
                        ↓ <br /> 
                        Checkup by consultant. <br /> 
                        ↓ <br /> 
                        Checkup by chief consultant . <br /> 
                        ↓ <br /> 
                        Medical Board for patient (if needed). <br /> 
                        ↓ <br /> 
                        Next follow up (any time or interval) <br />  <br /> 

                        N.B. : <br />
                        1. Patient finished all the above mentioned process without any fee except registration &
                        Subsequent follow up fee. <br /> 
                        2. Patient can take any primary suggestion ongoing office time over telephone. <br /> <br /> 
                        Time: <br /> 
                        Morning Shift: 09.00 AM – 02.00 PM <br /> 
                        Evening Shift: 04.00 PM – 10.00 PM <br /> 
                    </p>
                    
                    <h4>Component :</h4>
                    <p>
                        • Outdoor <br /> 
                        • Counseling <br /> 
                        • Laboratory <br /> 
                        • Awareness generation team <br /> 
                        • Research <br /> 
                        • Medical Camp <br /> 
                        • Physiotherapy <br /> 
                    </p>

                    <h4>Achievement :</h4>
                        
                    <p>
                        • Registered patients – 14,662. (Till 24 January 2015) <br /> 
                        • Per month newly Registered Hypertensive patient: 150-200. <br /> 
                        • Per month Follow-up patient: 800-900. <br /> 
                        • Regular Follow up patient 30-35% <br /> 
                        • Number of Research completed 9. <br /> 
                        • Published Research paper world heart journal.no.03 <br /> 
                        • Establishment of special Heart care unit and kidney care unit. <br /> 
                    </p>
                        
                    <h4>Services / Present Activity :</h4>

                    <p>
                        • Improving awareness of the people about Hypertension by seminar, symposium, open
                        Discussion Free blood pressure check up stall, Distribution of booklet, leaflet etc. <br />
                        • Arrange Scientific seminar, workshop etc. for medical personnel. <br />
                        • Treatment of hypertensive patient in centre by senior medical office, consultant, chief consultant and medical board. <br />
                        • Lab facilities at a minimum cost. <br />
                        • Arrange free medical camp. <br />
                        • Research work about hypertension and its complications. <br />
                    </p>
                        


                    <h4>Organogram :</h4>
                        
                    <p>
                        President <br />
                        Vice- President <br />
                        Secretary General <br />
                        Finance Sectary <br />
                        Office Sectary <br />
                        Executive member <br />
                        Executive member <br />
                    </p>

                    <h4>Registered Patient :</h4>
                        
                    <p>
                        • No. of. Total registered patient till 24 January 2014: 14,662. <br />
                        • Daily patient (average) – 45-50 <br />
                        • Registered Patient (Per day) – 07-10 <br />
                        • Flow up Patient (Per day) – 30-40 <br />
                    </p>
                        
                    <h4>Importance :</h4>
                    <p>
                        • Emphasis on counseling. <br />
                        • Emphasis on controlling Hypertension. <br />
                        • Emphasis on detecting Hypertensive patient. <br />
                        • Emphasis on control of risk factor control of pre Hypertensive & Hypertensive patient. <br />
                    </p>

                    <h4>Staff ( Total = 34)</h4>

                        <table class="table table-bordered text-center w-100 ml-sm-0" style="margin-left: -7px;">
                            <tr>
                                <th>Laboratory </th>
                                <th>Total</th>
                                <th>Centre</th>
                                <th>Total</th>
                            </tr>
                            <tr>
                                <td>Lab Technologist </td>
                                <td>01</td>
                                <td>Manager</td>
                                <td>01</td>
                            </tr>
                            <tr>
                                <td>Lab Technician</td>
                                <td>08</td>
                                <td>Assistant Manager</td>
                                <td>02</td>
                            </tr>
                            <tr>
                                <td>Receptionist</td>
                                <td>02</td>
                                <td>Office Assistant</td>
                                <td>04</td>
                            </tr>
                            <tr>
                                <td>X-ray Technician</td>
                                <td>02</td>
                                <td>Computer operator</td>
                                <td>01</td>
                            </tr>
                            <tr>
                                <td>Physiotherapist</td>
                                <td>02</td>
                                <td>Receptionist</td>
                                <td>04</td>
                            </tr>
                            <tr>
                                <td>Physiotherapist Assistant</td>
                                <td>02</td>
                                <td>IT officer</td>
                                <td>01</td>
                            </tr>
                            <tr>
                                <td>Guard</td>
                                <td>01</td>
                                <td>Nanny / Ayah</td>
                                <td>02</td>
                            </tr>
                            <tr>
                                <td>Swiper</td>
                                <td>01</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>


                    <h4>Research work: Done (01-09)</h4>
                        
                    <p>
                        Published in World Heat Journal <br />
                        • Prevalence and Risk factors of Hypertension in Bangladesh. (World Heart journal ISSN, 1556-4002, Volume 5, Number2). <br />
                        • Frequency of causes of Dropout among patient with Hypertension, (World Heart journal ISSN, 1556-4002, Volume 4, Number2). <br />
                        • Causes of Death in Hypertension patients by verbal Autopsy. (World Heart journal ISSN, 1556-4002, Volume 6, Number2). <br /> <br />
                        Published in National Journal <br />
                        • The challenges in the management of Hypertension in rural area. ( Presented in-Mumbai, India, 02 November 2012 ) <br />
                        • Control status of blood pressure among the Hypertensive patients. ( Presented in NHFB Dhaka , 01 December 2012 ) <br />
                        • The experiences in establishing a Hypertension Aare Centre in a remote area. ( Presented in NHFB, Dhaka 01, 2012 ) <br />
                        • Factors influence drop cut to Hypertension patient from follow up. ( Presented in NHFB, Dhaka , 01 December 2012 ) <br />
                        • Study of body mass index in adult Hypertensive patients. ( Presented in – Hotel Sheraton , haka, 2010 ) <br />
                        • Socio demographic characteristics of Hypertensive patients in Rangpur. ( Presented in – Hotel Sheraton, Dhaka, 2010 ) <br /> <br />
                        On going <br />
                        • Diabetic Mellitus in Hypertensive patients. <br />
                        • Prevalence of Hypertension among individual with family history of Hypertension. <br />
                    </p>


                    <h4>Patient instruction and Prescription Book: (Specimen)</h4>

                        <p>
                            • Patient Book prescribetion page <br />
                            • Patient Book list page <br />
                            • Patient Book Investigation page <br />
                            • Patient Book case pageCase History data sheet <br />
                        </p>
                        
                    <h4>Works and activities of Hypertension and Research Centre, Rangpur ( Done)</h4>
                    <p>
                        • Awareness generating program          : 162 <br />
                        • Scientific seminar                    : 25 <br />
                        • Free Medical Camp                     : 28 <br />
                        • Hypertension Screening Stall          : 13 <br />
                        • Hypertension Detection info centre    : 03 <br />
                        • National Day observed                 : 16 <br />
                        • World Hypertension Day observed       : 05 <br />
                        • Warm cloth Distribution               : 04 <br />
                        • Research work                         : 09 <br />
                    </p>
                        
                    <h4>Future plan :</h4>
                    <p>
                        • Establishment of Hypertension and Research centre, Rangpur in its own properties. <br />
                        • Establishment of target organ damage care unit such as Stroke care, Kidney care, Heart care, Eye care unit. <br />
                        • Development of guideline in management of Hypertension its complication. <br />
                        • To run Research work for better treatment. <br />
                        • Establishment Hypertension Care unit in every district In Bangladesh. <br />
                    </p>
                        
                    <h4>Correspondence :</h4>
                    <p>
                        Md. Anwar Hossain <br />
                        Manager <br />
                        Hypertension and Research Centre, Rangpur. <br />
                        House No.: 79, Road No. : 01, <br />
                        Jail Road, Dhap, Rangpur, Bangladesh. <br />
                        Contact Number: +88 01730-448610 <br />
                        E-mail: htn_rp@yahoo.com <br />
                    </p>

                    
                </div>
            </div>
        </div>
    </div>
</section>
<section id="contact">
    <div class="container">
        <div class="header text-center">
            <h2>Contact Us</h2>
        </div>
        <div class="row my-4">
            <div class="col-lg-4 text-left">
                <div class="text d-flex justify-content-center">
                    <p style="min-width: 290px;">
                        <span class="d-block"><i class="fa fa-map-marker pr-1"></i>House No.: 79, Road No. : 01, Jail Road,</span>
                        <span class="d-block pl-3">Dhap, Rangpur, Bangladesh.</span>
                    </p>
                </div>
            </div>
            <div class="col-lg-4 py-lg-0 py-4 text-left">
                <div class="d-flex justify-content-center">
                    <div class="text text-left">
                        <p style="min-width: 290px;"><i
                                class="fa fa-envelope pr-2"></i>htn_rp@yahoo.com</p>
                        <p style="min-width: 290px;"><i class="fa fa-phone pr-2"></i>+88 01730-448610</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 pt-lg-2">
                <div class="d-flex justify-content-center">
                    <div class="social_link text-left">
                        <a target="_blank" href="https://www.facebook.com/HTN.centre"><i class="fa fa-facebook-f"></i></a>
                        <a target="_blank" href="https://www.facebook.com/groups/CCH.HRC/?ref=pages_profile_groups_tab&source_id=105124049571816"><i class="fa fa-facebook-f"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================= About Part End ================= -->
@endsection