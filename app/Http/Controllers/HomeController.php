<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\CarType;
use App\Models\State;
use App\Models\CarProcess;
use App\Models\Testimonial;
use App\Models\About;
use App\Models\Blog;
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

    return view('home', compact(
        'states',
        'carTypes',
        'processes',
        'testimonials',
        'about',
         'blogs' 
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

    return view('blog-single', compact('blog', 'recentBlogs'));
}
    public function contact()
    {
        return view('contact');
    }
}
