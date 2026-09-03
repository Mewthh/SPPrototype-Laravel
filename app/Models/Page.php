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
 * @property string|null $link_type
 * @property string|null $link_url
 * @property int|null $link_target_id
 * @property string|null $link_target_slug
 * @property bool $open_in_new_tab
 * @property-read string|null $resolved_link_url
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['title', 'slug', 'content', 'image', 'link_type', 'link_url', 'link_target_id', 'link_target_slug', 'open_in_new_tab', 'status'])]
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
        'resolved_link_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'link_target_id' => 'integer',
            'open_in_new_tab' => 'boolean',
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

    /**
     * Get the resolved destination URL for this page/banner.
     *
     * @return Attribute<string|null, void>
     */
    protected function resolvedLinkUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->link_type || $this->link_type === 'none') {
                    return null;
                }

                if ($this->link_type === 'url') {
                    return $this->link_url;
                }

                if ($this->link_type === 'news' && $this->link_target_id) {
                    $news = News::find($this->link_target_id);
                    if ($news && $news->slug) {
                        return route('news.show', ['slug' => $news->slug]);
                    }
                }

                if ($this->link_type === 'activity' && $this->link_target_id) {
                    $activity = Activity::find($this->link_target_id);
                    if ($activity && $activity->slug) {
                        return route('activities.show', ['slug' => $activity->slug]);
                    }
                }

                if ($this->link_type === 'conference') {
                    if ($this->link_target_slug) {
                        return route('spp.show', ['year' => $this->link_target_slug]);
                    }
                    if ($this->link_target_id) {
                        $event = SppEvent::find($this->link_target_id);
                        if ($event) {
                            $year = $event->event_date ? $event->event_date->format('Y') : $event->slug;

                            return route('spp.show', ['year' => $year]);
                        }
                    }

                    return route('spp.show');
                }

                return null;
            }
        );
    }
}
