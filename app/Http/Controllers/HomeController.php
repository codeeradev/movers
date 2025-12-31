<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    $states = State::orderBy('name')->get();

    // Get all car types for dropdown
    $carTypes = CarType::orderBy('name')->get();

    // Car shifting process (already dynamic)
    $processes = CarProcess::where('status', 1)
        ->orderBy('sort_order')
        ->get();
$about = About::where('status', 1)->latest()->first();
    // 🔥 Testimonials (ACTIVE + ORDERED)
    $testimonials = Testimonial::where('status', 1)
        ->orderBy('sort_order')
        ->get();
          $blogs = Blog::where('status', 1)
        ->latest()
        ->take(3)
        ->get();

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
            $testimonials = Testimonial::where('status', 1)
        ->orderBy('sort_order')
        ->get();
        $about = About::where('status', 1)->latest()->first();
        return view('about',compact('about','testimonials'));
    }

    public function pricing()
    {
        return view('pricing');
    }

   public function happyClients()
{
    return view('happy-clients');
}

public function blog()
{
    $blogs = Blog::where('status', 1)
        ->latest()
        ->paginate(5); // 👈 per page 5 blogs

    return view('blog', compact('blogs'));
}
public function blogShow($slug)
{
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
