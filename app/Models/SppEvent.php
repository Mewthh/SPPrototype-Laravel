<?php

namespace App\Models;

use Database\Factories\SppEventFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string|null $image
 * @property Carbon|null $event_date
 * @property string|null $location
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['title', 'slug', 'description', 'image', 'event_date', 'location', 'status'])]
class SppEvent extends Model
{
    /** @use HasFactory<SppEventFactory> */
    use HasFactory;

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
        ];
    }
}
