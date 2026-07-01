<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('sort_order')->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.form', ['project' => new Project]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = '/storage/' . $request->file('image')->store('projects', 'public');
        }

        $data['tags'] = $this->parseTags($request->input('tags'));

        Project::create($data);

        return redirect()->route('admin.projects.index')->with('status', 'Project created.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.form', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = '/storage/' . $request->file('image')->store('projects', 'public');
        }

        $data['tags'] = $this->parseTags($request->input('tags'));

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('status', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return back()->with('status', 'Project deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:4',
            'description' => 'nullable|string',
            'link' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_published' => 'nullable|boolean',
            'image' => 'nullable|image|max:4096',
        ]);
    }

    private function parseTags(?string $raw): array
    {
        if (! $raw) return [];
        return collect(explode(',', $raw))
            ->map(fn ($t) => trim($t))
            ->filter()
            ->values()
            ->all();
    }
}
