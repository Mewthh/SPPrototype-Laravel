<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\NewsFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string|null $excerpt
 * @property string|null $image
 * @property-read string|null $image_url
 * @property string $status
 * @property CarbonInterface|null $published_at
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 */
#[Fillable(['title', 'slug', 'content', 'excerpt', 'image', 'status', 'published_at'])]
class News extends Model
{
    /** @use HasFactory<NewsFactory> */
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    /**
     * Get the resolved public URL for the image.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->image)) {
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
                if ($disk === 'local') {
                    $disk = 'public';
                }

                return Storage::disk($disk)->url($this->image);
            }
        );
    }
}
