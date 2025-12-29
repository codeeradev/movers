<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarType;
use App\Models\State;
class HomeController extends Controller
{
   public function index()
{
    // Get all states for pickup/drop dropdown
    $states =State::orderBy('name')->get();

    // Get all car types for dropdown
    $carTypes = CarType::orderBy('name')->get();

    // Return home view with these variables
    return view('home', compact('states', 'carTypes'));
}


    public function about()
    {
        return view('about');
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
        return view('blog');
    }

    public function contact()
    {
        return view('contact');
    }
}
