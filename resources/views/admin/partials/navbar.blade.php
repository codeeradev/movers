<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
<div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
  
  <a class="navbar-brand brand-logo font-weight-bold"
     href="{{ url('/') }}"
     style="font-size:28px; letter-spacing:1px; font-weight:800; text-transform:uppercase; color:#ffffff;">
    Cargo
  </a>

  <a class="navbar-brand brand-logo-mini font-weight-bold"
     href="{{ url('/') }}"
     style="font-size:22px; font-weight:800; text-transform:uppercase; color:#ffffff;">
    C
  </a>

</div>



  <div class="navbar-menu-wrapper d-flex align-items-stretch">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>

   

    <ul class="navbar-nav navbar-nav-right">

   

      {{-- Profile Dropdown --}}
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
          <div class="nav-profile-img">
            <img src="{{ asset('assets/images/faces/face28.png') }}" alt="image">
          </div>
          <div class="nav-profile-text">
            <p class="mb-1 text-black">admin</p>
          </div>
        </a>
        <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="profileDropdown">
          <div class="p-3 text-center bg-primary">
            <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{ asset('assets/images/faces/face28.png') }}" alt="">
          </div>
          <div class="p-2">
            <h5 class="dropdown-header text-uppercase pl-2 text-dark">User Options</h5>
           
            <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
              <span>Profile</span>
              <i class="mdi mdi-account-outline ml-1"></i>
            </a>
          <a class="dropdown-item py-1 d-flex align-items-center justify-content-between"
   href="{{ route('settings.index') }}">
    <span>Settings</span>
    <i class="mdi mdi-settings"></i>
</a>

<div class="dropdown-divider"></div>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button
        type="submit"
        class="dropdown-item py-1 d-flex align-items-center justify-content-between btn btn-link p-0 text-left"
        style="width:100%; text-decoration:none;"
    >
        <span>Log Out</span>
        <i class="mdi mdi-logout ml-1"></i>
    </button>
</form>

          </div>
        </div>
      </li>

    </ul>

    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>
