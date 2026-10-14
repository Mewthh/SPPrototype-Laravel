<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\MembershipInquiryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $ticket_id
 * @property int|null $user_id
 * @property string $inquirer_name
 * @property string $inquirer_email
 * @property string|null $inquirer_institution
 * @property string|null $inquirer_tier
 * @property string|null $application_type
 * @property string $query_type
 * @property string|null $last_known_membership
 * @property string|null $last_attendance_year
 * @property string|null $last_attendance_place
 * @property string|null $oath_year
 * @property string|null $oath_venue
 * @property string|null $known_membership_type
 * @property string|null $purpose
 * @property string|null $keywords
 * @property string|null $remarks
 * @property string $status
 * @property string $priority
 * @property string|null $admin_response
 * @property string|null $certificate_attached
 * @property string|null $certificate_size
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 * @property-read User|null $user
 */
class MembershipInquiry extends Model
{
    /** @use HasFactory<MembershipInquiryFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'ticket_id',
        'user_id',
        'inquirer_name',
        'inquirer_email',
        'inquirer_institution',
        'inquirer_tier',
        'application_type',
        'query_type',
        'last_known_membership',
        'last_attendance_year',
        'last_attendance_place',
        'oath_year',
        'oath_venue',
        'known_membership_type',
        'purpose',
        'keywords',
        'remarks',
        'status',
        'priority',
        'admin_response',
        'certificate_attached',
        'certificate_size',
    ];

    /**
     * Get the user that owns the inquiry.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate the next ticket ID (e.g. INQ-1043).
     */
    public static function nextTicketId(): string
    {
        $last = static::query()
            ->where('ticket_id', 'like', 'INQ-%')
            ->orderByDesc('id')
            ->value('ticket_id');

        if ($last && preg_match('/INQ-(\d+)/', $last, $matches)) {
            $nextNumber = ((int) $matches[1]) + 1;
        } else {
            $nextNumber = 1000 + (static::count() + 1);
        }

        return 'INQ-'.$nextNumber;
    }
}
