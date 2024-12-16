<header class="header-three">
    <div class="header-fixed-three header-fixed">
        <nav class="navbar navbar-expand-lg header-nav-three scroll-sticky">
            <div class="container">
                <div class="navbar-header">
                    <a id="mobile_btn" href="javascript:void(0);">
                        <span class="bar-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </a>
                    <a href="{{ route('home') }}" class="navbar-brand logo">
                        <img src="{{ asset('frontend-assets') }}/images/logo.png" class="img-fluid" alt="Logo">
                    </a>
                </div>
                <div class="main-menu-wrapper">
                    <div class="menu-header">
                        <a href="{{ route('home') }}" class="menu-logo">
                            <img src="{{ asset('frontend-assets') }}/images/logo.svg" class="img-fluid" alt="Logo">
                        </a>
                        <a id="menu_close" class="menu-close" href="javascript:void(0);">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                    <ul class="main-nav">
                        <li class="has-submenu active">
                            <a href="{{ route('home') }}">Home</a>
                            
                        </li>
                        <li class="has-submenu">
                            <a href="{{ route('about') }}">About</a>
                        </li>
                        <li class="has-submenu">
                            <a href="#">Courses</a>
                        </li>
                        <li class="has-submenu">
                            <a href="#">Success Story</a>
                        </li>
                        <li class="has-submenu">
                            <a href="#">Contact</a>
                        </li>
                    </ul>
                </div>
                <ul class="nav header-navbar-rht align-items-center">
                    {{-- <li class="nav-item">
                        <div>
                            <a href="javascript:void(0);" id="dark-mode-toggle" class="dark-mode-toggle  ">
                                <i class="fa-solid fa-moon"></i>
                            </a>
                            <a href="javascript:void(0);" id="light-mode-toggle" class="dark-mode-toggle ">
                                <i class="fa-solid fa-sun"></i>
                            </a>
                        </div>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link nav-icon" href="{{ route('login') }}"><i class="bi bi-person"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-icon" href=""><i class="bi bi-cart"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link login-three-head button" href=""><span>Enroll Now</span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>