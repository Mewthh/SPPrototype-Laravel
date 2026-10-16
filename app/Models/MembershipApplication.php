<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\MembershipApplicationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $membership_type
 * @property string $application_type
 * @property string $application_date
 * @property string|null $recommender_name
 * @property string|null $recommender_surname
 * @property string|null $recommender_first_name
 * @property string|null $recommender_email
 * @property string|null $recommender_suffix
 * @property string|null $alt_recommender_name
 * @property string|null $alt_recommender_email
 * @property string|null $alt_recommender_suffix
 * @property string $surname
 * @property string $first_name
 * @property string|null $middle_name
 * @property string|null $suffix
 * @property string|null $mobile_number
 * @property string|null $alt_mobile_number
 * @property string|null $birthdate
 * @property string|null $sex
 * @property string|null $civil_status
 * @property string|null $nationality
 * @property string|null $home_address
 * @property string|null $current_affiliation
 * @property string|null $current_position
 * @property string|null $institutional_email
 * @property string|null $highest_educational_attainment
 * @property string|null $degree
 * @property string|null $date_degree_obtained
 * @property string|null $institution_name
 * @property string|null $institution_address
 * @property string|null $cv_path
 * @property-read string|null $cv_url
 * @property string|null $proof_path
 * @property-read string|null $proof_url
 * @property bool $declaration_agree
 * @property bool $certification_confirm
 * @property string|null $certification_email
 * @property string $account_email
 * @property string $status
 * @property string|null $remarks
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 * @property-read User|null $user
 * @property-read string $full_name
 */
#[Fillable([
    'user_id',
    'membership_type',
    'application_type',
    'application_date',
    'recommender_name',
    'recommender_surname',
    'recommender_first_name',
    'recommender_email',
    'recommender_suffix',
    'alt_recommender_name',
    'alt_recommender_email',
    'alt_recommender_suffix',
    'surname',
    'first_name',
    'middle_name',
    'suffix',
    'mobile_number',
    'alt_mobile_number',
    'birthdate',
    'sex',
    'civil_status',
    'nationality',
    'home_address',
    'current_affiliation',
    'current_position',
    'institutional_email',
    'highest_educational_attainment',
    'degree',
    'date_degree_obtained',
    'institution_name',
    'institution_address',
    'cv_path',
    'proof_path',
    'declaration_agree',
    'certification_confirm',
    'certification_email',
    'account_email',
    'status',
    'remarks',
])]
class MembershipApplication extends Model
{
    /** @use HasFactory<MembershipApplicationFactory> */
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     *
     * @var list<string>
     */
    protected $appends = [
        'cv_url',
        'proof_url',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'declaration_agree' => 'boolean',
            'certification_confirm' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the applicant's full name.
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->surname}");
    }

    /**
     * Get the resolved public URL for the CV.
     *
     * @return Attribute<string|null, void>
     */
    protected function cvUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->cv_path === null || $this->cv_path === '') {
                    return null;
                }

                if (
                    str_starts_with($this->cv_path, 'http://') ||
                    str_starts_with($this->cv_path, 'https://')
                ) {
                    return $this->cv_path;
                }

                $disk = config('filesystems.default', 'public');
                $diskName = (is_string($disk) && $disk !== 'local') ? $disk : 'public';

                /** @var FilesystemAdapter $storage */
                $storage = Storage::disk((string) $diskName);

                // If file doesn't exist on default disk, check public disk fallback
                if (! $storage->exists($this->cv_path) && $diskName !== 'public') {
                    /** @var FilesystemAdapter $publicStorage */
                    $publicStorage = Storage::disk('public');
                    if ($publicStorage->exists($this->cv_path)) {
                        return $publicStorage->url($this->cv_path);
                    }
                }

                return $storage->url((string) $this->cv_path);
            }
        );
    }

    /**
     * Get the resolved public URL for the proof.
     *
     * @return Attribute<string|null, void>
     */
    protected function proofUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->proof_path === null || $this->proof_path === '') {
                    return null;
                }

                if (
                    str_starts_with($this->proof_path, 'http://') ||
                    str_starts_with($this->proof_path, 'https://')
                ) {
                    return $this->proof_path;
                }

                $disk = config('filesystems.default', 'public');
                $diskName = (is_string($disk) && $disk !== 'local') ? $disk : 'public';

                /** @var FilesystemAdapter $storage */
                $storage = Storage::disk((string) $diskName);

                // If file doesn't exist on default disk, check public disk fallback
                if (! $storage->exists($this->proof_path) && $diskName !== 'public') {
                    /** @var FilesystemAdapter $publicStorage */
                    $publicStorage = Storage::disk('public');
                    if ($publicStorage->exists($this->proof_path)) {
                        return $publicStorage->url($this->proof_path);
                    }
                }

                return $storage->url((string) $this->proof_path);
            }
        );
    }

    /**
     * Scope a query to filter by status.
     *
     * @param  Builder<MembershipApplication>  $query
     * @return Builder<MembershipApplication>
     */
    #[Scope]
    protected function status(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }
}
