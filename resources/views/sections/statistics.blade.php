@php
$rawStatItems = site_setting('home_stats_items');

if (is_string($rawStatItems)) {
$decoded = json_decode($rawStatItems, true);
$rawStatItems = json_last_error() === JSON_ERROR_NONE ? $decoded : [];
}

$statItems = is_array($rawStatItems) ? $rawStatItems : [];
@endphp

@push('styles')
<style>
  .stats-section {
    padding: 80px 0;
    background: #f0f2f5;
  }

  .stats-section .subheading {
    display: inline-block;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #FC983C;
    margin-bottom: 12px;
    position: relative;
    padding-left: 42px;
  }

  /* .stats-section .subheading::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    width: 32px;
    height: 2px;
    background: #FC983C;
    transform: translateY(-50%);
  } */

  .stats-section h2 {
    font-size: 36px;
    font-weight: 800;
    color: #1a1a2e;
    line-height: 1.25;
    margin-bottom: 0;
  }

  /* ── Stat Item ── */
  .stat-item {
    text-align: center;
    padding: 20px 10px;
    position: relative;
  }

  /* Divider between items */
  .stat-item+.stat-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    height: 60px;
    width: 1px;
    background: #d1d5db;
  }

  .stat-number {
    font-size: 56px;
    font-weight: 900;
    color: #FC983C;
    line-height: 1;
    margin-bottom: 10px;
    display: block;
    letter-spacing: -1px;
    font-variant-numeric: tabular-nums;
  }

  .stat-label {
    font-size: 14px;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    display: block;
  }

  @media (max-width: 767px) {
    .stats-section h2 {
      font-size: 26px;
    }

    .stat-number {
      font-size: 40px;
    }

    .stat-item+.stat-item::before {
      display: none;
    }
  }
</style>
@endpush

@if(!empty($statItems))
<section class="stats-section ftco-section">
  <div class="container">

    {{-- Heading --}}
    <div class="row justify-content-center mb-5">
      <div class="col-md-8 heading-section text-center ftco-animate">
        <span class="subheading">{{ site_setting('home_stats_subtitle', '') }}</span>
        <h2>{{ site_setting('home_stats_title', '') }}</h2>
      </div>
    </div>

    {{-- Stats --}}
    <div class="row gy-4">
      @foreach($statItems as $item)
      <div class="col-6 col-md-3 ftco-animate">
        <div class="stat-item">
          <span
            class="stat-number"
            data-target="{{ preg_replace('/[^0-9.]/', '', $item['value'] ?? '0') }}"
            data-suffix="{{ preg_replace('/[0-9.]+/', '', $item['value'] ?? '') }}">0</span>
          <span class="stat-label">{{ $item['label'] ?? '' }}</span>
        </div>
      </div>
      @endforeach
    </div>

  </div>
</section>
@endif

@push('scripts')
<script>
  (function() {
    function animateCounter(el) {
      var target = parseFloat(el.getAttribute('data-target')) || 0;
      var suffix = el.getAttribute('data-suffix') || '';
      var duration = 2000;
      var start = null;
      var isFloat = target % 1 !== 0;

      function step(timestamp) {
        if (!start) start = timestamp;
        var progress = Math.min((timestamp - start) / duration, 1);
        var eased = 1 - Math.pow(1 - progress, 3);
        var current = eased * target;
        el.textContent = (isFloat ? current.toFixed(1) : Math.floor(current)) + suffix;
        if (progress < 1) requestAnimationFrame(step);
      }

      requestAnimationFrame(step);
    }

    var counters = document.querySelectorAll('.stat-number[data-target]');
    if (!counters.length) return;

    var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.3
    });

    counters.forEach(function(el) {
      observer.observe(el);
    });
  })();
</script>
@endpush