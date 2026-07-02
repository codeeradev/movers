<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'Laxis Cargo Movers | Best Cargo Movers in Bangalore | Vehicle Transportation Services in Bangalore')</title>
    <meta name="description" content="@yield('meta_description', 'Need trusted Cargo Movers in Bangalore? Laxis Cargo Movers offers vehicle transportation services in Bangalore, including car transport, bike transport, household shifting, office relocation, packing, loading, unloading, and timely doorstep delivery. We focus on safe handling, transparent pricing, and customer satisfaction.')">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="canonical" href="https://laxiscargomovers.in/" />

    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=1.1.0">
    @if(site_setting('favicon'))
    <link rel="icon" href="{{ asset('uploads/settings/'.site_setting('favicon')) }}">
    @endif

    @stack('styles')

  @verbatim
    <script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@graph":[
    {
      "@type":"WebSite",
      "@id":"https://laxiscargomovers.in/#website",
      "url":"https://laxiscargomovers.in/",
      "name":"Laxis Cargo Movers",
      "publisher":{
        "@id":"https://laxiscargomovers.in/#business"
      }
    },
    {
      "@type":"WebPage",
      "@id":"https://laxiscargomovers.in/#webpage",
      "url":"https://laxiscargomovers.in/",
      "isPartOf":{
        "@id":"https://laxiscargomovers.in/#website"
      },
      "name":"Laxis Cargo Movers | Best Cargo Movers in Bangalore | Vehicle Transportation Services in Bangalore",
      "headline":"Trusted Cargo Movers in Bangalore for Safe & Secure Vehicle Transportation",
      "description":"Need trusted Cargo Movers in Bangalore? Laxis Cargo Movers offers vehicle transportation services in Bangalore, including car transport, bike transport, household shifting, office relocation, packing, loading, unloading, and timely doorstep delivery. We focus on safe handling, transparent pricing, and customer satisfaction."
    },
    {
      "@type":"MovingCompany",
      "@id":"https://laxiscargomovers.in/#business",
      "name":"Laxis Cargo Movers",
      "url":"https://laxiscargomovers.in/",
      "telephone":[
        "+91-9731166449",
        "+91-7899418883"
      ],
      "email":"laxiscargomovers@gmail.com",
      "description":"Need trusted Cargo Movers in Bangalore? Laxis Cargo Movers offers vehicle transportation services in Bangalore, including car transport, bike transport, household shifting, office relocation, packing, loading, unloading, and timely doorstep delivery. We focus on safe handling, transparent pricing, and customer satisfaction.",
      "address":{
        "@type":"PostalAddress",
        "streetAddress":"House No. 164, 18th Cross B, Hoysala Nagar, Ramamurthy Nagar",
        "addressLocality":"Bengaluru",
        "addressRegion":"Karnataka",
        "postalCode":"560016",
        "addressCountry":"IN"
      },
      "priceRange":"₹₹",
      "contactPoint":{
        "@type":"ContactPoint",
        "telephone":"+91-9731166449",
        "contactType":"customer service",
        "availableLanguage":[
          "English",
          "Hindi"
        ]
      }
    }
  ]
}
</script>
 @endverbatim

</head>

<body>
    <style>
        /* ===== SITE LOGO ===== */
        .site-logo {
            max-height: 60px;
            /* perfect for navbar */
            width: auto;
            object-fit: contain;
            transition: all 0.3s ease;
            background: transparent !important;
        }

        .brand-text {
            font-size: 26px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.02em;
        }

        /* Desktop */


        /* Mobile */
        @media (max-width: 768px) {
            .site-logo {
                max-height: 45px;
                background: black;
            }

            .brand-text {
                font-size: 20px;
            }
        }

        /* Optional hover effect */
        .navbar-brand:hover .site-logo {
            transform: scale(1.05);
        }
    </style>
    @include('partials.navbar')

    @yield('content')

    @include('partials.footer')
    {{-- AJAX Script --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/aos.js') }}"></script>
    <script src="{{ asset('js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('js/scrollax.min.js') }}"></script>
    <script src="{{ asset('js/google-map.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @stack('scripts')

    
</body>

</html>
