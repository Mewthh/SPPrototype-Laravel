<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class VideoController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Video::query()->latest('published_at')->latest('id')->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $this->validated($request);
        $video = Video::create($this->attributes($validated));

        return response()->json(['data' => $video, 'message' => 'Resource created successfully.'], 201);
    }

    public function update(Request $request, Video $video): JsonResponse
    {
        $validated = $this->validated($request);
        $video->update($this->attributes($validated));

        return response()->json(['data' => $video, 'message' => 'Resource updated successfully.']);
    }

    public function destroy(Video $video): JsonResponse
    {
        $video->delete();

        return response()->json(['message' => 'Resource deleted successfully.']);
    }

    /**
     * @return array{title: string, video_url: string, published_at?: string|null, status: 'draft'|'published'|'archived'}
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'video_url' => [
                'required',
                'url',
                'max:500',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    $video = new Video(['video_url' => $value]);

                    if (! $video->youtubeId()) {
                        $fail('Please enter a valid YouTube video link.');
                    }
                },
            ],
            'published_at' => [
                'nullable',
                'date',
                Rule::requiredIf($request->input('status') === 'published'),
            ],
            'status' => ['required', 'in:draft,published,archived'],
        ]);
    }

    /**
     * @param  array{title: string, video_url: string, published_at?: string|null, status: 'draft'|'published'|'archived'}  $validated
     * @return array{title: string, video_url: string, published_at: Carbon|null, status: 'draft'|'published'|'archived}
     */
    private function attributes(array $validated): array
    {
        return [
            'title' => $validated['title'],
            'video_url' => $validated['video_url'],
            'published_at' => isset($validated['published_at']) ? Carbon::parse($validated['published_at']) : null,
            'status' => $validated['status'],
        ];
    }
}
