<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'hero_headline'          => Setting::get('hero_headline', 'Bring the Outdoors In'),
            'hero_subtext'           => Setting::get('hero_subtext', ''),
            'hero_banner_image'      => Setting::get('hero_banner_image', ''),
            'store_discount_percent' => Setting::get('store_discount_percent', '0'),
        ];
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_headline'          => 'nullable|string|max:200',
            'hero_subtext'           => 'nullable|string|max:400',
            'store_discount_percent' => 'required|integer|min:0|max:90',
            'hero_banner'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        Setting::set('hero_headline',          $request->hero_headline ?? '');
        Setting::set('hero_subtext',           $request->hero_subtext ?? '');
        Setting::set('store_discount_percent', $request->store_discount_percent);

        if ($request->hasFile('hero_banner')) {
            $path = $request->file('hero_banner')->store('banners', 'public');
            Setting::set('hero_banner_image', $path);
        }

        return back()->with('success', 'Settings saved.');
    }
}
