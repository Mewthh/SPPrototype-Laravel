<?php

namespace App\Models;

use Database\Factories\SppEventFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string|null $year
 * @property string $title
 * @property string $slug
 * @property string|null $theme
 * @property string $description
 * @property string|null $image
 * @property-read string|null $image_url
 * @property Carbon|null $event_date
 * @property string|null $dates
 * @property string|null $location
 * @property string|null $summary
 * @property array<int, array<string, mixed>>|null $tabs
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['year', 'title', 'slug', 'theme', 'description', 'image', 'event_date', 'dates', 'location', 'summary', 'tabs', 'status'])]
class SppEvent extends Model
{
    /** @use HasFactory<SppEventFactory> */
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
     * Get the table associated with the model.
     *
     * @var string
     */
    protected $table = 'spp_events';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'tabs' => 'array',
        ];
    }

    /**
     * Scope a query to only include published conferences.
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
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
