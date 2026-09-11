<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name'])]
class DownloadCategory extends Model
{
    use HasFactory;

    public function downloads(): HasMany
    {
        return $this->hasMany(Download::class);
    }
}
