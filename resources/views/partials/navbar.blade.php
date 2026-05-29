<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
  <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
    @if(site_setting('logo'))
      <img src="{{ asset('uploads/settings/' . site_setting('logo')) }}"
           alt="{{ site_setting('site_name') ?? 'Logo' }}"
           class="site-logo">
    @else
      <span class="brand-text">{{ site_setting('site_name', 'Laxis Cargo Movers') }}</span>
    @endif
  </a>


        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
      <li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link">Home</a>
</li>
<li class="nav-item">
    <a href="{{ route('about-us') }}" class="nav-link">About</a>
</li>
<li class="nav-item">
    <a href="{{ route('services') }}" class="nav-link">Services</a>
</li>
<!--<li class="nav-item">
    <a href="{{ route('pricing') }}" class="nav-link">Pricing</a>
</li>-->
<li class="nav-item">
    <a href="{{ route('happy-clients') }}" class="nav-link">Happy Clients</a>
</li>

<li class="nav-item">
    <a href="{{ route('blog') }}" class="nav-link">Blog</a>
</li>
<li class="nav-item">
    <a href="{{ route('contact') }}" class="nav-link">Contact</a>
</li>

            </ul>
        </div>
    </div>
</nav>
