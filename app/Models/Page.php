<?php

namespace App\Models;

use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string|null $image
 * @property-read string|null $image_url
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['title', 'slug', 'content', 'image', 'status'])]
class Page extends Model
{
    /** @use HasFactory<PageFactory> */
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     *
     * @var list<string>
     */
    protected $appends = [
        'image_url',
    ];

    /**
     * Get the resolved public URL for the image.
     *
     * @return Attribute<string|null, void>
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->image === null || $this->image === '') {
                    return null;
                }

                if (
                    str_starts_with($this->image, 'http://') ||
                    str_starts_with($this->image, 'https://') ||
                    str_starts_with($this->image, 'data:')
                ) {
                    return $this->image;
                }

                $disk = config('filesystems.default', 'public');
                $diskName = is_string($disk) && $disk !== 'local' ? $disk : 'public';

                return Storage::disk($diskName)->url($this->image);
            }
        );
    }
}
