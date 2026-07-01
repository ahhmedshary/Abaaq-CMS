<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class PortfolioController extends Controller
{
    /**
     * GET /api/portfolio
     * Single endpoint returning everything the Next.js frontend needs.
     * Kept as one call on purpose: fewer round trips for a small site.
     */
    public function index(): JsonResponse
    {
        $profile = Profile::first();

        return response()->json([
            'profile' => $profile ? [
                'name' => $profile->name,
                'role' => $profile->role,
                'tagline' => $profile->tagline,
                'location' => $profile->location,
                'email' => $profile->email,
                'avatar' => $profile->avatar,
                'resumeUrl' => $profile->resume_url,
                'social' => $profile->social ?? [],
            ] : null,
            'stats' => $profile->stats ?? [],
            'projects' => Project::where('is_published', true)
                ->orderBy('sort_order')
                ->get()
                ->map(fn ($p) => [
                    'id' => $p->id,
                    'title' => $p->title,
                    'category' => $p->category,
                    'year' => $p->year,
                    'description' => $p->description,
                    'image' => $p->image,
                    'tags' => $p->tags ?? [],
                    'link' => $p->link,
                ]),
            'skills' => Skill::orderBy('sort_order')->get()
                ->map(fn ($s) => [
                    'group' => $s->group_name,
                    'items' => $s->items ?? [],
                ]),
            'experience' => Experience::orderBy('sort_order')->get()
                ->map(fn ($e) => [
                    'period' => $e->period,
                    'role' => $e->role,
                    'org' => $e->org,
                    'description' => $e->description,
                ]),
            'testimonials' => Testimonial::orderBy('sort_order')->get()
                ->map(fn ($t) => [
                    'quote' => $t->quote,
                    'name' => $t->name,
                    'role' => $t->role,
                ]),
        ]);
    }
}
