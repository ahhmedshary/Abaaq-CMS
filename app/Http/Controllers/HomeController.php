<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index', [
            'categories' => Category::orderBy('sort_order')->get(),
            'featured' => Product::where('is_published', true)->where('is_featured', true)
                ->orderBy('sort_order')->limit(6)->get(),
            'onOffer' => Product::where('is_published', true)->where('is_on_offer', true)
                ->orderBy('sort_order')->limit(6)->get(),
            'latest' => Product::where('is_published', true)
                ->latest()->limit(6)->get(),
            'settings' => [
                'hero_title' => Setting::get('hero_title', 'بيوت عامرة بريحة الطيب'),
                'hero_subtitle' => Setting::get('hero_subtitle', 'نقدّم لك بخور فاخر وعود أصيل ومباخر تعبّرّ عن جمال تراثنا وتملأ بيوتك بأجواء دافئة ومعطّرة بالطيب'),
                'hero_image' => Setting::get('hero_image', '/images/hero-bottle.jpg'),
                'about_text' => Setting::get('about_text', 'عبق الشرق اسم يرتبط بالطيب والذوق الرفيع، نقدم إحساس بالفخامة من زاوية بيتك، من ريحة الطيب اللي تعكس أصالة الشرق، لمباخر أنيقة تزيد المكان جمال، كل شي مصمم ليعبر عن ذوق سعودي راقٍ'),
                'banner_title' => Setting::get('banner_title', 'جديد عبق بلمسة أصيلة'),
                'banner_subtitle' => Setting::get('banner_subtitle', 'تشكيلة جديدة تجمع بين الفخامة وتزين بيتك بلمسة شرقية أصيلة'),
                'offer_title' => Setting::get('offer_title', 'خصم يوصل لـ 30% على تشكيلة العود الملكي'),
                'offer_ends_at' => Setting::get('offer_ends_at', now()->addDays(4)->toIso8601String()),
                'instagram_handle' => Setting::get('instagram_handle', '@YourStoreHandle'),
            ],
        ]);
    }
}
