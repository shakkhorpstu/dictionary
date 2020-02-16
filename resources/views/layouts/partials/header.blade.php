<!--Header Area Start-->
<header class="header-two">
    <!-- <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="header-login-register">
                            <ul class="login">
                                <li>
                                    <a href="{{ route('index') }}"><i class="fa fa-key"></i>Login</a>
                                    <div class="login-form">
                                        <h4>Login</h4>
                                        <form action="{{ route('index') }}" method="post">
                                            <div class="form-box">
                                                <i class="fa fa-user"></i>
                                                <input type="text" name="user-name" placeholder="Username">
                                            </div>
                                            <div class="form-box">
                                                <i class="fa fa-lock"></i>
                                                <input type="password" name="user-password" placeholder="Password">
                                            </div>
                                            <div class="button-box">
                                                <button type="submit" class="login-btn">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                            <ul class="register">
                                <li>
                                    <a href="{{ route('index') }}"><i class="fa fa-lock"></i>Sign Up</a>
                                    <div class="register-form">
                                        <h4>Sign Up</h4>
                                        <span>Please sign up using account detail bellow.</span>
                                        <form action="{{ route('index') }}" method="post">
                                            <div class="form-box">
                                                <i class="fa fa-user"></i>
                                                <input type="text" name="user-name" placeholder="Username">
                                            </div>
                                            <div class="form-box">
                                                <i class="fa fa-lock"></i>
                                                <input type="password" name="user-password" placeholder="Password">
                                            </div>
                                            <div class="form-box">
                                                <i class="fa fa-envelope"></i>
                                                <input type="email" name="user-email" placeholder="Email">
                                            </div>
                                            <div class="button-box">
                                                <div class="toggle btn btn-primary" data-toggle="toggle" style="width: 63px; height: 38px;"><input checked="" data-toggle="toggle" type="checkbox">
                                                    <div class="toggle-group"><label class="btn btn-primary toggle-on">On</label><label class="btn btn-default active toggle-off">Off</label><span class="toggle-handle btn btn-default"></span></div>
                                                </div>
                                                <span>Remember me</span>
                                                <button type="submit" class="register-btn">Register</button>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    <!--Logo Mainmenu Start-->
    <div class="header-logo-menu sticker" style="opacity: 1;">
        <div class="container">
            <div class="logo-menu-bg">
                <div class="row">
                    <div class="col-lg-3 col-md-12">
                        <div class="logo">
                            <a href="{{ route('index') }}"><img src="{{ asset('public/images/logo.png') }}"
                                    alt="DM Words"></a>
                        </div>
                    </div>
                    <div class="col-lg-9 d-none d-lg-block">
                        <div class="mainmenu-area">
                            <div class="mainmenu">
                                <nav>
                                    <ul id="nav">
                                        <li><a href="{{ route('index') }}">Learn <i class="fa fa-angle-down"></i></a>
                                            <ul class="sub-menu">
                                                <li>
                                                    <a href="#">
                                                        <img src="{{ asset('public/images/countries/fi.png') }}" alt=""
                                                            class="flag-icon">
                                                        Finnish - English
                                                        <img src="{{ asset('public/images/countries/us.png') }}" alt=""
                                                            class="flag-icon">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <img src="{{ asset('public/images/countries/fi.png') }}" alt=""
                                                            class="flag-icon">
                                                        Finnish - Albanian
                                                        <img src="{{ asset('public/images/countries/al.png') }}" alt=""
                                                            class="flag-icon">
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a href="{{ route('index') }}">DM Words</a></li>
                                        <li><a href="{{ route('index') }}">Blog</a></li>
                                        <li><a href="{{ route('index') }}">Marketing</a></li>
                                        <li>
                                            <a href="{{ route('index') }}">
                                                Language <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="sub-menu">
                                                <li>
                                                    <a href="#">
                                                        <img src="{{ asset('public/images/countries/us.png') }}" alt=""
                                                            class="flag-icon">English
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <img src="{{ asset('public/images/countries/fi.png') }}" alt=""
                                                            class="flag-icon">Finnish
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>

                                    </ul>
                                </nav>
                            </div>
                            <ul class="header-search">
                                <li class="search-menu">
                                    <i id="toggle-search" class="fa fa-search"></i>
                                </li>
                            </ul>
                            <!--Search Form-->
                            <div class="search">
                                <div class="search-form">
                                    <form id="search-form" action="{{ route('index') }}">
                                        <input type="search" placeholder="Search here..." name="search">
                                        <button type="submit">
                                            <span><i class="fa fa-search"></i></span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <!--End of Search Form-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End of Logo Mainmenu-->
    <!-- Mobile Menu Area start -->
    <div class="mobile-menu-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="mobile-menu">
                        <nav id="dropdown" style="display: block;">
                            <ul id="nav">
                                <li><a href="{{ route('index') }}">Learn <i class="fa fa-angle-down"></i></a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="#">
                                                <img src="{{ asset('public/images/countries/fi.png') }}" alt=""
                                                    class="flag-icon">
                                                Finnish - English
                                                <img src="{{ asset('public/images/countries/us.png') }}" alt=""
                                                    class="flag-icon">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img src="{{ asset('public/images/countries/fi.png') }}" alt=""
                                                    class="flag-icon">
                                                Finnish - Albanian
                                                <img src="{{ asset('public/images/countries/al.png') }}" alt=""
                                                    class="flag-icon">
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('index') }}">DM Words</a></li>
                                <li><a href="{{ route('index') }}">Blog</a></li>
                                <li><a href="{{ route('index') }}">Marketing</a></li>
                                <li>
                                    <a href="{{ route('index') }}">
                                        Language <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="#">
                                                <img src="{{ asset('public/images/countries/us.png') }}" alt=""
                                                    class="flag-icon">English
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img src="{{ asset('public/images/countries/fi.png') }}" alt=""
                                                    class="flag-icon">Finnish
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu Area end -->
</header>
<!--End of Header Area-->