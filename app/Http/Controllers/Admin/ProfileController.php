<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = Profile::firstOrCreate(['id' => 1], [
            'name' => '', 'role' => '', 'tagline' => '', 'email' => '',
        ]);

        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'tagline' => 'required|string|max:500',
            'location' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'avatar' => 'nullable|image|max:2048',
            'social_labels.*' => 'nullable|string|max:50',
            'social_urls.*' => 'nullable|url',
            'stat_values.*' => 'nullable|string|max:20',
            'stat_labels.*' => 'nullable|string|max:100',
        ]);

        $profile = Profile::firstOrCreate(['id' => 1]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $profile->avatar = '/storage/' . $path;
        }

        $social = collect($request->input('social_labels', []))
            ->map(fn ($label, $i) => [
                'label' => $label,
                'url' => $request->input('social_urls')[$i] ?? '',
            ])
            ->filter(fn ($s) => $s['label'] && $s['url'])
            ->values();

        $stats = collect($request->input('stat_values', []))
            ->map(fn ($value, $i) => [
                'value' => $value,
                'label' => $request->input('stat_labels')[$i] ?? '',
            ])
            ->filter(fn ($s) => $s['value'] && $s['label'])
            ->values();

        $profile->fill([
            'name' => $data['name'],
            'role' => $data['role'],
            'tagline' => $data['tagline'],
            'location' => $data['location'] ?? null,
            'email' => $data['email'],
            'social' => $social,
            'stats' => $stats,
        ])->save();

        return back()->with('status', 'Profile updated.');
    }
}
