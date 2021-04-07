<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\UsesUuid;

class ResumeWorkExperience extends Model
{
    use HasFactory;
    use UsesUuid;

    protected $fillable = [
        'resume_id',
        'position_title',
        'position_skill',
        'position_company',
        'position_start_date',
        'position_end_date',
        'resume_description_ids',
        'current_employer',
        'order',
    ];


    protected $dates = [
        'position_start_date',
        'position_end_date',
    ];

    protected $casts = [
        'position_start_date' => 'datetime:Y-m-d',
        'position_end_date'   => 'datetime:Y-m-d',
    ];

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }

    public function resumeDescriptions()
    {
        return $this->hasMany(ResumeDescription::class);
    }
}
