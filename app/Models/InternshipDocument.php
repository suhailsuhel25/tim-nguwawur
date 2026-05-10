<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InternshipDocument extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class);
    }
}
