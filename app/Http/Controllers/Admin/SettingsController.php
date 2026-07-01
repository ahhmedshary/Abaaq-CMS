<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    private array $keys = [
        'hero_title', 'hero_subtitle', 'about_text',
        'banner_title', 'banner_subtitle',
        'offer_title', 'offer_ends_at', 'instagram_handle',
    ];

    public function edit()
    {
        $values = [];
        foreach ($this->keys as $key) {
            $values[$key] = Setting::get($key);
        }

        return view('admin.settings.edit', ['values' => $values]);
    }

    public function update(Request $request)
    {
        foreach ($this->keys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key));
            }
        }

        return back()->with('status', 'تم حفظ إعدادات الصفحة الرئيسية.');
    }
}
