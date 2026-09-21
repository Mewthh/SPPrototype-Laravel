<?php

namespace App\Http\Controllers;

use App\Models\MembershipFaq;
use Illuminate\Contracts\View\View;

class MembershipFaqController extends Controller
{
    public function index(): View
    {
        return view('membership-faq', [
            'faqs' => MembershipFaq::query()->visible()->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }
}
