<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    <li class="nav-item nav-category">Admin Panel</li>

    <!-- Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/') }}">
        <span class="icon-bg">
          <i class="mdi mdi-view-dashboard menu-icon"></i>
        </span>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <!-- Price Management Dropdown -->
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#priceMenu" aria-expanded="false" aria-controls="priceMenu">
        <span class="icon-bg">
          <i class="mdi mdi-currency-inr menu-icon"></i>
        </span>
        <span class="menu-title">Price Management</span>
        <i class="menu-arrow"></i>
      </a>

      <div class="collapse" id="priceMenu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('price-list.index') }}">
              Price List
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{ route('price-list.create') }}">
              Add Price
            </a>
          </li>

          {{-- Car Types --}}
          <li class="nav-item">
            <a class="nav-link" href="{{ route('car-types.index') }}">
              Car Types
            </a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Logout -->
    <li class="nav-item sidebar-user-actions mt-3">
      <div class="sidebar-user-menu">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="nav-link btn btn-link p-0 text-left">
            <i class="mdi mdi-logout menu-icon"></i>
            <span class="menu-title">Log Out</span>
          </button>
        </form>
      </div>
    </li>

  </ul>
</nav>
