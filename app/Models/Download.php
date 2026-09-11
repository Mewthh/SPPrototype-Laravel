<?php

namespace App\Models;

use Database\Factories\DownloadFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $category
 * @property int|null $year
 * @property string $file_url
 * @property string $file_name
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['download_category_id', 'title', 'description', 'category', 'year', 'file_url', 'file_name', 'status'])]
class Download extends Model
{
    /** @use HasFactory<DownloadFactory> */
    use HasFactory;

    public function downloadCategory(): BelongsTo
    {
        return $this->belongsTo(DownloadCategory::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'year' => 'integer',
        ];
    }

    /**
     * Generate a temporary S3 presigned URL for downloading the private file.
     */
    public function getTemporaryDownloadUrl(int $minutes = 15): string
    {
        if (
            str_starts_with($this->file_url, 'http://') ||
            str_starts_with($this->file_url, 'https://')
        ) {
            return $this->file_url;
        }

        $privateDisk = config('filesystems.private', 'r2-private');

        try {
            return Storage::disk($privateDisk)->temporaryUrl(
                $this->file_url,
                now()->addMinutes($minutes),
                [
                    'ResponseContentDisposition' => 'attachment; filename="'.rawurlencode($this->file_name).'"',
                ]
            );
        } catch (\Throwable) {
            // Fallback for local or drivers without presigned URL support
            return Storage::disk($privateDisk)->url($this->file_url);
        }
    }
}
