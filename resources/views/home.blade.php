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
                <h2>Our Programs</h2>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-2 g-lg-3">

            <div class="col item item-1">
                <a href="#" class="card">
                    <div class="card-body">
                        <h5>Smoking Awarness</h5>
                        <p>Learn More<i class="far fa-arrow-alt-circle-right"></i></p>
                    </div>
                </a>
            </div>

            <div class="col item item-1">
                <a href="#" class="card">
                    <div class="card-body">
                        <h5>Ethics for doctors</h5>
                        <p>Learn More<i class="far fa-arrow-alt-circle-right"></i></p>
                    </div>
                </a>
            </div>

            <div class="col item item-1">
                <a href="#" class="card">
                    <div class="card-body">
                        <h5>Rohingya Healthcare Issues</h5>
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
                            This might be the best charitable and non-profit institution.
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
                            Hope it will be more friendly for doctors
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
                            Thanks to CMEER for arranging awarness programs for health related issues.
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
                        I wish successful journey of CMEER</p>
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

                <p class="py-2">
                    Centre for Medical Education, Ethics and Research ( CMEER ) is a prominent non-profit, non-political non-governmental national institution which works in medical arena.
                </p>

                <p class="py-2">
                    It was established in 2016 having headquarter in Dhaka. 
                </p>

                <p class="py-2">
                    CMEER was established by a group of medical professionals with a view to work solely on education, ethics & research  aspect of medical science. Since establishment CMEER has arranged lots of educational programs specially for resident students & post graduate trainees of different institutions.
                </p>

                <p class="py-2">
                    CMEER is continuously trying to uplift ethical practices among medical professionals by conducting various types of workshop on ethical issues, like Doctor patient relationship, doctor pharmaceuticals relationship etc. As a new organization CMEER has not done much on research field but currently taking initiatives to launch few research projects.
                </p>

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
                        <span class="d-block"><i class="fa fa-map-marker pr-1"></i>Address: 2/4 Shahbag,</span>
                        <span class="d-block pl-3">Dhaka, Bangladesh.</span>
                    </p>
                </div>
            </div>
            <div class="col-lg-4 py-lg-0 py-4 text-left">
                <div class="d-flex justify-content-center">
                    <div class="text text-left">
                        <p style="min-width: 290px;"><i
                                class="fa fa-envelope pr-2"></i>cmeer.bd@gmail.com</p>
                        <p style="min-width: 290px;"><i class="fa fa-phone pr-2"></i>+88 01759-616000</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 pt-lg-2">
                <div class="d-flex justify-content-center">
                    <div class="social_link text-left">
                        <a target="_blank" href="#"><i class="fa fa-facebook-f"></i></a>
                        <a target="_blank" href="#"><i class="fa fa-youtube"></i></a>
                        <a target="_blank" href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================= About Part End ================= -->
@endsection