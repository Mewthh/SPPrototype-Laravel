<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutPageRequest extends FormRequest
{
    protected function getRedirectUrl(): string
    {
        return route('dashboard').'#about-section';
    }

    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'introduction' => ['required', 'string', 'max:5000'],
            'council_heading' => ['required', 'string', 'max:255'],
            'officers' => ['required', 'array', 'min:1'],
            'officers.*.name' => ['required', 'string', 'max:255'],
            'officers.*.institution' => ['required', 'string', 'max:500'],
            'officers.*.role' => ['required', 'string', 'max:255'],
            'councilors' => ['nullable', 'array'],
            'councilors.*.name' => ['required', 'string', 'max:255'],
            'councilors.*.institution' => ['required', 'string', 'max:500'],
            'address' => ['required', 'string', 'max:1000'],
            'email' => ['required', 'email', 'max:255'],
            'image' => ['nullable', 'image', 'max:10240'],
            'remove_image' => ['nullable', 'boolean'],
        ];
    }
}
