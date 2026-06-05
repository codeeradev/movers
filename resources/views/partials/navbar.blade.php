<style>
    /* Desktop default */
    #ftco-navbar .nav-link {
        color: #fff;
    }

    /* MOBILE FIX */
    @media (max-width: 991px) {

        #ftco-navbar {
            background: #ffffff !important;
        }

        #ftco-navbar .nav-link,
        #ftco-navbar .brand-text {
            color: #000 !important;
        }

        /* Black hamburger icon */
        #ftco-navbar .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(0,0,0,1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            @if(site_setting('logo'))
            <img src="{{ asset('uploads/settings/' . site_setting('logo')) }}"
                alt="{{ site_setting('site_name') ?? 'Logo' }}"
                class="site-logo">
            @else
            <span class="brand-text">
                {{ site_setting('site_name', 'Laxis Cargo Movers') }}
            </span>
            @endif
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="{{ route('about-us') }}" class="nav-link">About</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="{{ route('services') }}" id="servicesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Services
                    </a>
                    <div class="dropdown-menu" aria-labelledby="servicesDropdown">
                        @if(!empty($navServices) && $navServices->isNotEmpty())
                            @foreach($navServices as $service)
                                <a class="dropdown-item" href="{{ route('services.single', $service->slug) }}">{{ $service->title }}</a>
                            @endforeach
                            <div class="dropdown-divider"></div>
                        @endif
                        <a class="dropdown-item" href="{{ route('services') }}">View All Services</a>
                    </div>
                </li>
                <li class="nav-item"><a href="{{ route('happy-clients') }}" class="nav-link">Happy Clients</a></li>
                <li class="nav-item"><a href="{{ route('blog') }}" class="nav-link">Blog</a></li>
                <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact</a></li>
            </ul>
        </div>

    </div>
</nav>