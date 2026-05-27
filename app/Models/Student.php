<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use SoftDeletes;

    public const STUDY_PROGRAMS = [
        'Matematika',
        'Biologi',
        'Fisika',
        'Kimia',
        'Teknik Lingkungan',
        'Gizi',
        'Teknologi Informasi',
    ];

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function internships(): HasMany
    {
        return $this->hasMany(Internship::class);
    }
}
