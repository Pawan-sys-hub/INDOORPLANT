<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $newArrivals   = Product::active()->with('category')->latest()->take(8)->get();
        $bestSellers   = Product::active()->featured()->with('category')->take(8)->get();
        $categories    = Category::withCount(['products' => fn($q) => $q->active()])->get();
        $discountPct   = (int) Setting::get('store_discount_percent', 0);
        $heroBanner    = Setting::get('hero_banner_image');
        $heroHeadline  = Setting::get('hero_headline', 'Bring the Outdoors In');
        $heroSubtext   = Setting::get('hero_subtext', 'Premium indoor plants delivered to your door.');

        return view('home', compact(
            'newArrivals', 'bestSellers', 'categories',
            'discountPct', 'heroBanner', 'heroHeadline', 'heroSubtext'
        ));
    }
}
