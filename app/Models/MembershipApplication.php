<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\MembershipApplicationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property string|null $proof_path
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
