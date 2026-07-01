<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        return view('admin.experience.index', ['rows' => Experience::orderBy('sort_order')->get()]);
    }

    public function create()
    {
        return view('admin.experience.form', ['row' => new Experience]);
    }

    public function store(Request $request)
    {
        Experience::create($this->validated($request));
        return redirect()->route('admin.experience.index')->with('status', 'Experience added.');
    }

    public function edit(Experience $experience)
    {
        return view('admin.experience.form', ['row' => $experience]);
    }

    public function update(Request $request, Experience $experience)
    {
        $experience->update($this->validated($request));
        return redirect()->route('admin.experience.index')->with('status', 'Experience updated.');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();
        return back()->with('status', 'Experience deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'period' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'org' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);
    }
}
