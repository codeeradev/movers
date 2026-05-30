@php
$rawChooseItems = data_get($settings ?? null, 'home_choose_items') ?? site_setting('home_choose_items');

if (is_string($rawChooseItems)) {
$decodedChooseItems = json_decode($rawChooseItems, true);
$rawChooseItems = json_last_error() === JSON_ERROR_NONE ? $decodedChooseItems : [];
}

$chooseItems = is_array($rawChooseItems) ? $rawChooseItems : [];

if (is_string($chooseItems)) {
$decodedChooseItems = json_decode($chooseItems, true);
$chooseItems = json_last_error() === JSON_ERROR_NONE ? $decodedChooseItems : [];
}
@endphp

@push('styles')
<style>
  .why-choose-section {
    padding: 80px 0;
    background: #f4f6fb;
  }

  .why-choose-section .subheading {
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

  /* .why-choose-section .subheading::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    width: 32px;
    height: 2px;
    background: #FC983C;
    transform: translateY(-50%);
  } */

  .why-choose-section h2 {
    font-size: 36px;
    font-weight: 800;
    color: #1a1a2e;
    line-height: 1.25;
  }

  .choose-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 36px 28px 32px;
    height: 100%;
    border: 1.5px solid #eaedf5;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
    transition: all 0.35s ease;
    position: relative;
    overflow: hidden;
  }

  .choose-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(180deg, #FC983C, #ff6b3d);
    transform: scaleY(0);
    transform-origin: bottom;
    transition: transform 0.35s ease;
  }

  .choose-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(232, 64, 28, 0.12);
    border-color: rgba(232, 64, 28, 0.2);
  }

  .choose-card:hover::before {
    transform: scaleY(1);
  }

  /* Icon box only shows background when flaticon glyph is present */
  .choose-icon-box {
    width: 64px;
    height: 64px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 22px;
    transition: all 0.35s ease;
    background: transparent;
  }

  /* Background only applies when the span inside has a valid flaticon class rendering */
  .choose-icon-box:has([class^="flaticon-"]:not(:empty)),
  .choose-icon-box:has([class*=" flaticon-"]:not(:empty)) {
    background: linear-gradient(135deg, #fff3f0, #ffe8e2);
  }

  /* Always show background — but only color the icon if font loads */
  .choose-icon-box {
    background: linear-gradient(135deg, #fff3f0, #ffe8e2);
  }

  .choose-card:hover .choose-icon-box {
    background: linear-gradient(135deg, #FC983C, #ff6b3d);
    box-shadow: 0 8px 20px rgba(232, 64, 28, 0.3);
  }

  .choose-icon-box [class^="flaticon-"],
  .choose-icon-box [class*=" flaticon-"] {
    font-size: 30px;
    color: #FC983C;
    transition: color 0.35s ease;
    line-height: 1;
  }

  .choose-card:hover .choose-icon-box [class^="flaticon-"],
  .choose-card:hover .choose-icon-box [class*=" flaticon-"] {
    color: #ffffff;
  }

  .choose-card-number {
    position: absolute;
    top: 14px;
    right: 20px;
    font-size: 44px;
    font-weight: 900;
    color: #f0f2f8;
    line-height: 1;
    pointer-events: none;
    user-select: none;
    transition: color 0.35s ease;
  }

  .choose-card:hover .choose-card-number {
    color: rgba(232, 64, 28, 0.06);
  }

  .choose-card h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 10px;
    line-height: 1.3;
  }

  .choose-card p {
    font-size: 14.5px;
    color: #6b7280;
    line-height: 1.75;
    margin-bottom: 0;
  }

  @media (max-width: 767px) {
    .why-choose-section h2 {
      font-size: 26px;
    }

    .choose-card {
      padding: 26px 20px;
    }
  }
</style>
@endpush

@if(!empty($chooseItems))
<section class="why-choose-section ftco-section">
  <div class="container-fluid px-4">

    <div class="row justify-content-center mb-5">
      <div class="col-md-8 heading-section text-center ftco-animate">
        <span class="subheading">{{ site_setting('home_choose_subtitle', 'Why Choose Us') }}</span>
        <h2 class="mb-2">{{ site_setting('home_choose_title', 'Why Choose Us') }}</h2>
      </div>
    </div>

    <div class="row gy-4" style="row-gap: 10px;">
      @foreach($chooseItems as $index => $item)
      <div class="col-12 col-md-6 col-lg-4 ftco-animate">
        <div class="choose-card">
          <span class="choose-card-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>

          @if(!empty($item['icon']))
          <div class="choose-icon-box">
            <span class="{{ $item['icon'] }}"></span>
          </div>
          @endif

          <h3>{{ $item['title'] ?? '' }}</h3>
          <p>{{ $item['description'] ?? '' }}</p>
        </div>
      </div>
      @endforeach
    </div>

  </div>
</section>
@endif