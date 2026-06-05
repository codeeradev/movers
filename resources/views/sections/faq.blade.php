@php
    $faqItems = $faqs ?? collect();
    $faqTitle = $faqTitle ?? 'Frequently Asked Questions';
    $faqIntro = $faqIntro ?? 'Find answers about our packing, moving, transportation, and relocation services.';
    $faqBadges = $faqBadges ?? ['Transparent Pricing', 'Safe Relocation', '24/7 Support'];
    $faqBadgeLabel = $faqBadgeLabel ?? 'FAQs';
@endphp

@if($faqItems->isNotEmpty())
@push('styles')
<style>
    .premium-faq-section {
        position: relative;
        padding: 96px 0;
        overflow: hidden;
        background:
            radial-gradient(circle at top left, rgba(252, 152, 60, 0.12), transparent 28%),
            radial-gradient(circle at bottom right, rgba(7, 20, 43, 0.12), transparent 35%),
            linear-gradient(180deg, #f8fbff 0%, #ffffff 100%);
    }

    .premium-faq-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(7, 20, 43, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(7, 20, 43, 0.03) 1px, transparent 1px);
        background-size: 72px 72px;
        mask-image: linear-gradient(180deg, rgba(0, 0, 0, 0.65), transparent 92%);
        pointer-events: none;
    }

    .premium-faq-shell {
        position: relative;
        display: grid;
        grid-template-columns: minmax(0, 0.95fr) minmax(0, 1.25fr);
        gap: 28px;
        align-items: start;
        z-index: 1;
    }

    .premium-faq-left {
        position: sticky;
        top: 110px;
        padding: 34px;
        border-radius: 24px;
        background:
            linear-gradient(145deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.02)),
            linear-gradient(135deg, #07142B 0%, #0D1F45 100%);
        color: #e5eefb;
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 28px 80px rgba(7, 20, 43, 0.22);
        overflow: hidden;
    }

    .premium-faq-left::after {
        content: '';
        position: absolute;
        inset: auto -70px -90px auto;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(252, 152, 60, 0.22), transparent 70%);
        filter: blur(8px);
        pointer-events: none;
    }

    .premium-faq-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 16px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #fff;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        backdrop-filter: blur(10px);
    }

    .premium-faq-left h2 {
        margin: 22px 0 16px;
        color: #ffffff;
        font-size: clamp(34px, 4.8vw, 54px);
        font-weight: 900;
        line-height: 1.02;
        letter-spacing: -0.05em;
    }

    .premium-faq-left p {
        margin: 0;
        max-width: 520px;
        font-size: 17px;
        line-height: 1.8;
        color: rgba(229, 238, 251, 0.84);
    }

    .premium-faq-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 26px;
    }

    .premium-faq-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 16px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #f8fbff;
        font-size: 14px;
        font-weight: 700;
        line-height: 1;
        backdrop-filter: blur(12px);
        transition: transform 0.25s ease, background 0.25s ease, border-color 0.25s ease;
    }

    .premium-faq-chip:hover {
        transform: translateY(-2px);
        background: rgba(255, 255, 255, 0.12);
        border-color: rgba(255, 255, 255, 0.16);
    }

    .premium-faq-right {
        display: grid;
        gap: 14px;
    }

    .premium-faq-card {
        border-radius: 18px;
        border: 1px solid rgba(15, 23, 42, 0.08);
        background: rgba(255, 255, 255, 0.92);
        box-shadow: 0 12px 34px rgba(15, 23, 42, 0.06);
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        backdrop-filter: blur(10px);
    }

    .premium-faq-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 42px rgba(15, 23, 42, 0.08);
    }

    .premium-faq-card.is-open {
        border-color: rgba(252, 152, 60, 0.55);
        box-shadow: 0 18px 48px rgba(252, 152, 60, 0.12);
    }

    .premium-faq-question {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 22px 22px;
        border: 0;
        background: transparent;
        text-align: left;
        color: #07142B;
        font-size: 17px;
        font-weight: 700;
        line-height: 1.45;
        cursor: pointer;
        transition: background-color 0.25s ease, color 0.25s ease;
    }

    .premium-faq-question:hover {
        background: rgba(252, 152, 60, 0.03);
    }

    .premium-faq-question:focus-visible {
        outline: 3px solid rgba(252, 152, 60, 0.35);
        outline-offset: -3px;
    }

    .premium-faq-question span:first-child {
        flex: 1 1 auto;
    }

    .premium-faq-icon {
        flex: 0 0 auto;
        width: 38px;
        height: 38px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(252, 152, 60, 0.12), rgba(252, 152, 60, 0.18));
        color: #fc983c;
        border: 1px solid rgba(252, 152, 60, 0.15);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.55);
        transition: transform 0.25s ease, background 0.25s ease, color 0.25s ease;
    }

    .premium-faq-card.is-open .premium-faq-icon {
        transform: rotate(0deg);
        background: linear-gradient(135deg, rgba(252, 152, 60, 0.16), rgba(252, 152, 60, 0.24));
    }

    .premium-faq-icon svg {
        width: 16px;
        height: 16px;
        stroke-width: 2.75;
    }

    .premium-faq-answer {
        padding: 0 22px 22px;
        color: #43536b;
        font-size: 15.5px;
        line-height: 1.95;
    }

    .premium-faq-answer p {
        margin: 0;
    }

    .premium-faq-answer .answer-shell {
        padding-top: 2px;
    }

    @media (max-width: 991px) {
        .premium-faq-shell {
            grid-template-columns: 1fr;
        }

        .premium-faq-left {
            position: relative;
            top: auto;
        }
    }

    @media (max-width: 767px) {
        .premium-faq-section {
            padding: 72px 0;
        }

        .premium-faq-left {
            padding: 26px;
            border-radius: 22px;
        }

        .premium-faq-left h2 {
            font-size: 32px;
            margin-top: 18px;
        }

        .premium-faq-left p {
            font-size: 15px;
        }

        .premium-faq-question {
            padding: 18px 18px;
            font-size: 15px;
        }

        .premium-faq-answer {
            padding: 0 18px 18px;
        }
    }
</style>
@endpush

<section class="premium-faq-section ftco-section">
    <div class="container">
        <div class="premium-faq-shell">
            <aside class="premium-faq-left ftco-animate">
                <span class="premium-faq-badge">{{ $faqBadgeLabel }}</span>
                <h2>{{ $faqTitle }}</h2>
                <p>{{ $faqIntro }}</p>

                <div class="premium-faq-chips">
                    @foreach($faqBadges as $badge)
                        <span class="premium-faq-chip">✓ {{ $badge }}</span>
                    @endforeach
                </div>
            </aside>

            <div class="premium-faq-right ftco-animate" id="premiumFaqAccordion">
                @foreach($faqItems as $faq)
                    <article class="premium-faq-card {{ $loop->first ? 'is-open' : '' }}">
                        <button
                            class="premium-faq-question"
                            type="button"
                            data-toggle="collapse"
                            data-target="#faq-{{ $faq->id }}"
                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                            aria-controls="faq-{{ $faq->id }}"
                            aria-label="Toggle FAQ: {{ $faq->question }}">
                            <span>{{ $faq->question }}</span>
                            <span class="premium-faq-icon" aria-hidden="true">
                                <svg class="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round">
                                    <path d="M12 5v14"></path>
                                    <path d="M5 12h14"></path>
                                </svg>
                            </span>
                        </button>

                        <div
                            id="faq-{{ $faq->id }}"
                            class="collapse {{ $loop->first ? 'show' : '' }}"
                            data-parent="#premiumFaqAccordion">
                            <div class="premium-faq-answer">
                                <div class="answer-shell">
                                    <p>{!! nl2br(e($faq->answer)) !!}</p>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    (function () {
        const cards = document.querySelectorAll('.premium-faq-card');

        cards.forEach((card) => {
            const toggle = card.querySelector('.premium-faq-question');
            const collapseEl = card.querySelector('.collapse');

            if (!toggle || !collapseEl) {
                return;
            }

            collapseEl.addEventListener('show.bs.collapse', () => {
                card.classList.add('is-open');
                toggle.setAttribute('aria-expanded', 'true');
            });

            collapseEl.addEventListener('hide.bs.collapse', () => {
                card.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
            });
        });
    })();
</script>
@endpush
@endif
