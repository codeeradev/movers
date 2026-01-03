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

    <!-- Price Management -->
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
          <li class="nav-item">
            <a class="nav-link" href="{{ route('car-types.index') }}">
              Car Types
            </a>
          </li>
        </ul>
      </div>
    </li>

    <!-- 🚗 Car Shifting Process -->
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#processMenu" aria-expanded="false" aria-controls="processMenu">
        <span class="icon-bg">
          <i class="mdi mdi-car-multiple menu-icon"></i>
        </span>
        <span class="menu-title">Car Shifting Process</span>
        <i class="menu-arrow"></i>
      </a>

      <div class="collapse" id="processMenu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('car-process.index') }}">
              Process List
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('car-process.create') }}">
              Add New Step
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('car-process.gallery') }}">
              Manage Images
            </a>
          </li>
        </ul>
      </div>
    </li>

    <!-- ⭐ Slider Management (NEW) -->
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#sliderMenu" aria-expanded="false" aria-controls="sliderMenu">
        <span class="icon-bg">
          <i class="mdi mdi-image-multiple menu-icon"></i>
        </span>
        <span class="menu-title">Home Management</span>
        <i class="menu-arrow"></i>
      </a>

      <div class="collapse" id="sliderMenu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('testimonials.index') }}">
              Testimonials
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('testimonials.create') }}">
              Add Testimonial
            </a>
          </li>
           <!-- About Section -->
      <li class="nav-item">
        <a class="nav-link" href="{{ route('about.index') }}">
          About Section
        </a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="{{ route('about.create') }}">
          Add About Content
        </a>
      </li>
        </ul>
      </div>
    </li>
<!-- 📝 Blog Management -->
<li class="nav-item">
  <a class="nav-link" data-toggle="collapse" href="#blogMenu" aria-expanded="false" aria-controls="blogMenu">
    <span class="icon-bg">
      <i class="mdi mdi-note-text-outline menu-icon"></i>
    </span>
    <span class="menu-title">Blog Management</span>
    <i class="menu-arrow"></i>
  </a>

  <div class="collapse" id="blogMenu">
    <ul class="nav flex-column sub-menu">

      <li class="nav-item">
        <a class="nav-link" href="{{ route('blogs.index') }}">
          Blog List
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('blogs.create') }}">
          Add Blog
        </a>
      </li>

    </ul>
  </div>
</li>

<!-- 📩 Requests Management -->
<li class="nav-item">
  <a class="nav-link" data-toggle="collapse" href="#requestMenu"
     aria-expanded="false" aria-controls="requestMenu">
    <span class="icon-bg">
      <i class="mdi mdi-email-outline menu-icon"></i>
    </span>
    <span class="menu-title">Requests</span>
    <i class="menu-arrow"></i>
  </a>

  <div class="collapse" id="requestMenu">
    <ul class="nav flex-column sub-menu">

      <!-- Contact Messages -->
      <li class="nav-item">
        <a class="nav-link" href="{{ route('contact-messages.index') }}">
          Contact Messages
        </a>
      </li>

      <!-- Car Move Requests -->
      <li class="nav-item">
        <a class="nav-link" href="{{ route('car-move-requests.index') }}">
          Car Move Requests
        </a>
      </li>

    </ul>
  </div>
</li>



    <!-- ⚙️ Settings -->
<li class="nav-item">
  <a class="nav-link" href="{{ route('settings.index') }}">
    <span class="icon-bg">
    <i class="mdi mdi-cog menu-icon"></i>

    </span>
    <span class="menu-title">Settings</span>
  </a>
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
