<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Fillable(['title', 'image', 'first_label', 'first_url', 'first_opens_in_new_tab', 'second_label', 'second_url', 'second_opens_in_new_tab'])]
/** @property-read string|null $image_url */
class ProceedingsTemplate extends Model
{
    protected $appends = ['image_url'];

    protected function casts(): array
    {
        return [
            'first_opens_in_new_tab' => 'boolean',
            'second_opens_in_new_tab' => 'boolean',
        ];
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function (): ?string {
                if ($this->image === null || $this->image === '' || str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
                    return $this->image;
                }

                $disk = config('filesystems.default', 'public');

                return Storage::disk($disk === 'local' ? 'public' : $disk)->url($this->image);
            },
        );
    }
}
