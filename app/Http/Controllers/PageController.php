<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Testimonial;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Home', [
            'services' => Service::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->limit(3)
                ->get(),
            'testimonials' => Testimonial::query()
                ->where('is_visible', true)
                ->orderBy('sort_order')
                ->get(),
        ]);
    }

    public function services(): Response
    {
        return Inertia::render('Services', [
            'services' => Service::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
        ]);
    }
}
