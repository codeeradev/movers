<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\CarType;
use App\Models\State;
use App\Models\CarProcess;
use App\Models\Testimonial;
use App\Models\About;
use App\Models\Faq;
use App\Models\Setting;
use App\Models\Blog;
use App\Models\Service;
class HomeController extends Controller
{
public function index()
{
    // Get all states for pickup/drop dropdown
    $states = Schema::hasTable('states') ? State::orderBy('name')->get() : collect();

    // Get all car types for dropdown
    $carTypes = Schema::hasTable('car_types') ? CarType::orderBy('name')->get() : collect();

    // Car shifting process (already dynamic)
    $processes = Schema::hasTable('car_processes')
        ? CarProcess::where('status', 1)->orderBy('sort_order')->get()
        : collect();

    $about = Schema::hasTable('abouts')
        ? About::where('status', 1)->latest()->first()
        : null;
    // 🔥 Testimonials (ACTIVE + ORDERED)
    $testimonials = Schema::hasTable('testimonials')
        ? Testimonial::where('status', 1)->orderBy('sort_order')->get()
        : collect();

    $blogs = Schema::hasTable('blogs')
        ? Blog::where('status', 1)->latest()->take(3)->get()
        : collect();

    $services = Schema::hasTable('services')
        ? Service::where('status', 1)->orderBy('sort_order')->orderBy('id')->get()
        : collect();

    $homeFaqs = Schema::hasTable('faqs')
        ? Faq::where('status', 1)
            ->where('scope', 'home')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
        : collect();

    $settings = Schema::hasTable('settings') ? Setting::first() : null;

    return view('home', compact(
        'states',
        'carTypes',
        'processes',
        'testimonials',
        'about',
         'blogs',
         'services',
         'homeFaqs',
         'settings'
    ));
}


    public function about()
    {
        $testimonials = Schema::hasTable('testimonials')
            ? Testimonial::where('status', 1)->orderBy('sort_order')->get()
            : collect();
        $about = Schema::hasTable('abouts')
            ? About::where('status', 1)->latest()->first()
            : null;
        return view('about',compact('about','testimonials'));
    }

    public function pricing()
    {
        return view('pricing');
    }

   public function happyClients()
{
      $testimonials = Schema::hasTable('testimonials')
          ? Testimonial::where('status', 1)->orderBy('sort_order')->get()
          : collect();
    return view('happy-clients',compact('testimonials'));
}

public function blog()
{
    $blogs = Schema::hasTable('blogs')
        ? Blog::where('status', 1)->latest()->paginate(5)
        : new \Illuminate\Pagination\LengthAwarePaginator([], 0, 5, 1, [
            'path' => url()->current(),
        ]);

    return view('blog', compact('blogs'));
}
public function blogShow($slug)
{
    abort_unless(Schema::hasTable('blogs'), 404);

    $blog = Blog::where('slug', $slug)
        ->where('status', 1)
        ->firstOrFail();

    $recentBlogs = Blog::where('status', 1)
        ->where('id', '!=', $blog->id)
        ->latest()
        ->take(3)
        ->get();

    $blogFaqs = Schema::hasTable('faqs')
        ? Faq::where('status', 1)
            ->where('scope', 'blog')
            ->where('blog_id', $blog->id)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
        : collect();

    return view('blog-single', compact('blog', 'recentBlogs', 'blogFaqs'));
}

public function services()
{
    $services = Schema::hasTable('services')
        ? Service::where('status', 1)->orderBy('sort_order')->orderBy('id')->get()
        : collect();

    return view('services', compact('services'));
}

public function serviceShow($slug)
{
    abort_unless(Schema::hasTable('services'), 404);

    $service = Service::where('slug', $slug)
        ->where('status', 1)
        ->firstOrFail();

    $recentServices = Service::where('status', 1)
        ->where('id', '!=', $service->id)
        ->orderBy('id', 'desc')
        ->take(3)
        ->get();

    $serviceFaqs = Schema::hasTable('faqs')
        ? Faq::where('status', 1)
            ->where('scope', 'service')
            ->where('service_id', $service->id)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
        : collect();

    return view('service-single', compact('service', 'recentServices', 'serviceFaqs'));
}
    public function contact()
    {
        return view('contact');
    }
}
