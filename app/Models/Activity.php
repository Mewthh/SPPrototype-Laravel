<?php

namespace App\Models;

use Database\Factories\ActivityFactory;
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
 * @property string|null $summary
 * @property string $description
 * @property string|null $image
 * @property-read string|null $image_url
 * @property Carbon|null $event_date
 * @property string|null $location
 * @property string $status
 * @property bool $is_featured
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['title', 'slug', 'summary', 'description', 'image', 'event_date', 'location', 'status', 'is_featured'])]
class Activity extends Model
{
    /** @use HasFactory<ActivityFactory> */
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
            'event_date' => 'date',
            'is_featured' => 'boolean',
        ];
    }

    /**
     * Get the resolved public URL for the image.
     *
     * @return Attribute<string|null, void>
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->image) || ! is_string($this->image)) {
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
