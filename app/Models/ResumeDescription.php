<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\UsesUuid;

class ResumeDescription extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UsesUuid;

    protected $fillable = [
        'description',
        'resume_work_experience_id',
        'type',
        'sort_order',
    ];

    public function resumeWorkExperience()
    {
        return $this->belongsTo(ResumeWorkExperience::class);
    }

}
