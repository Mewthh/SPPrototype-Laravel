<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\AnnouncementFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $target_audience
 * @property string|null $summary
 * @property string $content
 * @property string $status
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 * @property-read string $audience_label
 */
#[Fillable(['title', 'target_audience', 'summary', 'content', 'status'])]
class Announcement extends Model
{
    /** @use HasFactory<AnnouncementFactory> */
    use HasFactory;

    /**
     * @var array<string, string>
     */
    public const AUDIENCE_LABELS = [
        'all' => 'All Applicants & Members',
        'regular' => 'Regular Members Only',
        'associate' => 'Associate Members Only',
        'institutional' => 'Institutional Members Only',
    ];

    /**
     * Scope a query to only include published announcements.
     *
     * @param  Builder<Announcement>  $query
     * @return Builder<Announcement>
     */
    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    /**
     * Get the human-readable audience label.
     *
     * @return Attribute<string, void>
     */
    protected function audienceLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => self::AUDIENCE_LABELS[$this->target_audience] ?? 'All Applicants & Members'
        );
    }
}
