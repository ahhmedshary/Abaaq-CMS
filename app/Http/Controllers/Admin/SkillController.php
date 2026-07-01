<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        return view('admin.skills.index', ['skills' => Skill::orderBy('sort_order')->get()]);
    }

    public function create()
    {
        return view('admin.skills.form', ['skill' => new Skill]);
    }

    public function store(Request $request)
    {
        Skill::create($this->validated($request));
        return redirect()->route('admin.skills.index')->with('status', 'Skill group added.');
    }

    public function edit(Skill $skill)
    {
        return view('admin.skills.form', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $skill->update($this->validated($request));
        return redirect()->route('admin.skills.index')->with('status', 'Skill group updated.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return back()->with('status', 'Skill group deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'group_name' => 'required|string|max:255',
            'items' => 'required|string',
            'sort_order' => 'nullable|integer',
        ]);

        $data['items'] = collect(explode(',', $data['items']))
            ->map(fn ($i) => trim($i))
            ->filter()
            ->values()
            ->all();

        return $data;
    }
}
