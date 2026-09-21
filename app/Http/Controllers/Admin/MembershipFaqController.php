<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipFaq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MembershipFaqController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => MembershipFaq::query()->orderBy('sort_order')->orderBy('id')->get()]);
    }

    public function store(Request $request): JsonResponse
    {
        $faq = MembershipFaq::create($this->validated($request) + ['sort_order' => (MembershipFaq::max('sort_order') ?? 0) + 1]);

        return response()->json(['data' => $faq, 'message' => 'FAQ created successfully.'], 201);
    }

    public function update(Request $request, MembershipFaq $membershipFaq): JsonResponse
    {
        $membershipFaq->update($this->validated($request));

        return response()->json(['data' => $membershipFaq, 'message' => 'FAQ updated successfully.']);
    }

    public function destroy(MembershipFaq $membershipFaq): JsonResponse
    {
        $membershipFaq->delete();

        return response()->json(['message' => 'FAQ deleted successfully.']);
    }

    /** @return array{question: string, answer: string, is_visible: bool} */
    private function validated(Request $request): array
    {
        return $request->validate([
            'question' => ['required', 'string', 'max:1000'],
            'answer' => ['required', 'string', 'max:10000'],
            'is_visible' => ['required', 'boolean'],
        ]);
    }
}
