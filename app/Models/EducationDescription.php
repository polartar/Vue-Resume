<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\UsesUuid;

class EducationDescription extends Model
{
    use SoftDeletes;
    use UsesUuid;

    protected $fillable = [
        'resume_education_id',
        'description',
        'type',
        'sort_order'
    ];

    public function resumeEducation() 
    {
        return $this->belongsTo(ResumeEducation::class);
    }
}
