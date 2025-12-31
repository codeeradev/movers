<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">CAR<span>GO</span></a>
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
    <a href="{{ route('pricing') }}" class="nav-link">Pricing</a>
</li>
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
