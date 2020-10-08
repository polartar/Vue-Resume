<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\UsesUuid;

class ResumeEducation extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UsesUuid;

    protected $fillable = [
        'resume_id',
        'school_name',
        'type', // This is mapped as an enum, see migration or db for options
        'degree_received',
        'field_of_study',
        'completed',
        'start_date',
        'end_date',
        'currently_studying',
    ];


    protected $dates = [
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime:Y-m-d',
        'end_date' => 'datetime:Y-m-d',
    ];

    public function resume()
    {
        $this->belongsTo(Resume::class);
    }

    public function educationDescriptions()
    {
        return $this->hasMany(EducationDescription::class);
    }
}
