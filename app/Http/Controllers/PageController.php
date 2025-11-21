<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    //
    public function faqs()
    {
        $faqs = Faq::orderBy('order_position', 'desc')
            ->get();

        return Inertia::render('Front/Faq/Index', [
            'faqs' => $faqs,
        ]);
    }
}
