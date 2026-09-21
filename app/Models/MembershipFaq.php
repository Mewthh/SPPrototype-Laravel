<?php

namespace App\Models;

use Database\Factories\MembershipFaqFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $question
 * @property string $answer
 * @property bool $is_visible
 * @property int $sort_order
 */
#[Fillable(['question', 'answer', 'is_visible', 'sort_order'])]
class MembershipFaq extends Model
{
    /** @use HasFactory<MembershipFaqFactory> */
    use HasFactory;

    /**
     * @param  Builder<MembershipFaq>  $query
     * @return Builder<MembershipFaq>
     */
    #[Scope]
    protected function visible(Builder $query): Builder
    {
        return $query->where('is_visible', true);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['is_visible' => 'boolean', 'sort_order' => 'integer'];
    }
}
