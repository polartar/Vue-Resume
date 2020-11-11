<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\UsesUuid;

class Resume extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UsesUuid;

    protected $fillable = [
        'user_id',
        'name',
        'resume_design_id',
        'pdf_url',
        'user_address_id',
        'user_phone_id',
        'user_email_id',
        'user_address_ids',
        'user_phone_ids',
        'user_email_ids',
        'date_format',
    ];

    protected $casts = [
        'user_address_ids' => 'array',
        'user_phone_ids' => 'array',
        'user_email_ids' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function phone()
    {
        return $this->belongsTo(UserPhone::class, 'user_phone_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function email()
    {
        return $this->belongsTo(UserEmail::class, 'user_email_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'user_address_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function resumeWorkExperiences()
    {
        return $this->hasMany(ResumeWorkExperience::class)->orderBy('order');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function resumeEducations()
    {
        return $this->hasMany(ResumeEducation::class)->orderBy('order');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function resumeDesign()
    {
        return $this->belongsTo(ResumeDesign::class);
    }

    public function resumeSummaries()
    {
        return $this->hasMany(ResumeSummary::class)->orderBy('order');
    }

    public function resumeSkill()
    {
        return $this->hasMany(ResumeSkill::class);
    }

    public function getFirstAddressAttribute()
    {
        if($this->user_address_ids){
            return UserAddress::find($this->user_address_ids)->first();
        }
    }

    public function getFirstResumeSummaryAttribute()
    {
        if($this->resume_summaries){
            return ResumeSummary::find($this->resume_summaries)->first();
        }
    }

    public function hobbies()
    {
        return $this->hasMany(Hobby::class)->orderBy('order');
    }
}
