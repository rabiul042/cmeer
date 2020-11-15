<!DOCTYPE html>
<html lang="en" style="min-height: 100vh;">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Control High Blood Pressure, let be healthy &nbsp; &nbsp; &nbsp; Hypertension and Research Centre, Rangpur (A sister concern of Dr. Wasim – Waleda Bahumukhi Kallyan Foundaion) Dhap, Jail Road, Rangpur, Phone: +8801730448610 e-mail: htn_rp@yahoo.com Hypertension and Research Centre, Rangpur Table of Contents 1. Preface 2. Establishment 3. Objectives 4. Government Approval 5. Subscription fee 6. &hellip;">
    <meta name="keywords" content="Hypertension, Research, Rangpur, Hypertension and Research Center, Hypertension and Research Center, Rangpur,">
    <meta name="author" content="Hypertension and Research Center, Rangpur">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font Embed -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Main CSS & Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('css/msi-plugin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/msi-main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/msi-responsive.css') }}">

    <!-- icon -->
    <link rel="icon" href="{{ asset('images/icon.png')}}" type="image/png" sizes="16x16" />

    <title>Hypertension and Research Center, Rangpur</title>

</head>

<body class="d-flex flex-column h-100" style="background-color: #f7f9fb;">
    <!-- ================= Menu Part Start ================= -->
    <nav id="menu_part" class="navbar navbar-expand-lg main_menu shadow-sm fixed-top">
        <div class="container-lg container p-0">
            <a class="navbar-brand d-flex p-lg-0 py-0 pl-3 m-0" href="{{ route('home') }}" action="{{ route('home') }}">
                <img class="mobile-logo" src="{{asset('images/logo.png')}}" alt="logo">
                <img class="pc-logo" src="{{asset('images/logo_newf.png')}}" alt="logo">
            </a>
            <button class="navbar-toggler p-0 mr-3" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fa fa-bars menu_bar"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}" action="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#course">Course</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#gallery">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#testimonial">Testimonial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#faq">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#footer">Contact</a>
                    </li>
                    @guest
                    <li class="nav-item">
                        <a class="nav-link menu_button" href="{{ route('login') }}">Login</a>
                    </li>
                    @else
                    <li class="dropdown nav-item">
                        <a href="#" class="dropdown-toggle nav-link menu_button user_profile" data-toggle="dropdown"
                            role="button" aria-expanded="false" aria-haspopup="true">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li class="text-center border-bottom">
                                <a class="py-2 w-100" href="{{ url('my-profile') }}">Dashboard</a>
                                <span class="d-none">{{ Auth::id() }}</span>
                            </li>
                            <li class="text-center">
                                <a class="py-2 w-100" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>

                        </ul>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <!-- ================= Menu Part End ================= -->
    
    <!-- ================= Main Content Start ================= -->
    
    <main id="app" style="padding: 80px 0 0;">

        @yield('content')
        
    </main>

    <!-- ================= Main Content End ================= -->



    <!-- ================= Footer Start ================= -->
    <footer class="mt-auto">
        <div class="py-4 bg-secondary">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <p class="text-white">&copy; 2008 - {{ date("Y") }}
                            <a class="pl-2 text-white btn-link" href="{{url('/')}}">htncr.com</a>
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <p class="text-white">Developed by <a class="pl-2 text-white btn-link"
                                href="http://www.medigeneit.com/">Medigene IT</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ================= Footer End ================= -->


    <!-- popper & Botstrap v5 -->
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- jQuery -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <!-- js Start -->
    @yield('js')

    <!-- js End -->

    <!-- plugin.js then msin.js >> Must will be bottom of body -->
    <script src="{{ asset('js/msi-plugin.js') }}"></script>
    <script src="{{ asset('js/msi-main.js') }}"></script>
</body>

</html>