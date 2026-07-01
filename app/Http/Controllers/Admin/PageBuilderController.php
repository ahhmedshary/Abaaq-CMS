<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSection;
use Illuminate\Http\Request;

class PageBuilderController extends Controller
{
    public function index()
    {
        $sections = PageSection::where('page', 'home')
            ->orderBy('sort_order')
            ->get();

        return view('admin.page-builder.index', compact('sections'));
    }

    public function edit(PageSection $section)
    {
        return view('admin.page-builder.edit', compact('section'));
    }

    public function update(Request $request, PageSection $section)
    {
        $settings = $request->except(['_token', '_method']);
        $section->update(['settings' => $settings]);

        return redirect()->route('admin.page-builder.index')
            ->with('status', "تم حفظ إعدادات \"{$section->label}\".");
    }

    /** PATCH /admin/page-builder/{section}/toggle */
    public function toggle(PageSection $section)
    {
        $section->update(['is_visible' => ! $section->is_visible]);

        return response()->json(['is_visible' => $section->is_visible]);
    }

    /** POST /admin/upload-image */
    public function uploadImage(Request $request)
    {
        $request->validate(['image' => 'required|image|max:4096']);

        $path = $request->file('image')->store('sections', 'public');

        return response()->json(['url' => '/storage/' . $path]);
    }
    public function reorder(Request $request)
    {
        $request->validate(['sections' => 'required|array', 'sections.*.id' => 'required|integer', 'sections.*.order' => 'required|integer']);

        foreach ($request->sections as $item) {
            PageSection::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }

        return response()->json(['ok' => true]);
    }
}
