<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="{{ asset('assets/css/resumes/gold-standard.css') }}">
    </head>
    <body class="resume-pdf resume-gold-standard">
        <div class="print-paper">
            <table class="full-width-table" align="center" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td>
                            <p class="resume-title">{{ $resume->user->full_name }}</p>
                        </td>
                        <td>
                            <table class="full-width-table header-contact-info" align="center" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <p class="contact-info">{{ $resume->first_address->city ?? '' }}, {{ $resume->first_address->province ?? '' }}</p>
                                        </td>
                                    </tr>

                                    @if($resume->user->user_phones->first())
                                    <tr>
                                        <td>
                                            <p class="contact-info">{{ $resume->user->user_phones->first()->phone_number }}</p>
                                        </td>
                                    </tr>
                                    @endif

                                    <tr>
                                        <td>
                                            <p class="contact-info">{{ $resume->user->email }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="contact-info">LinkedIn URL (todo)</p>
                                        </td>
                                    </tr>

                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="full-width-table resume-section" align="center" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td><span class="section-heading">Summary</span></td>
                    </tr>
                    <tr>
                        <td class="section-summary">
                            @if(isset($resume->resumeSummaries))
                                <ul>
                                    @foreach ($resume->resumeSummaries as $summary)
                                        <li class="@if(!$summary->bullet_point) paragraph-bullet-point @endif">{{ $summary->name }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            @if ($workExperienceSectionBreak)
                <div class="page-break"></div>
                <div style="padding-top: 75px;">&nbsp;</div>
            @endif
            <table class="full-width-table resume-section" align="center" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td><span class="section-heading">Work Experience</span></td>
                    </tr>

                    @foreach( $resume->resumeWorkExperiences as $key=>$work )
                        <tr>
                            <td class="section-group">
                                <!-- This line will cleanly break a page -->
                                @if(in_array($key, $workExperienceIndexBreaks))
                                    <div class="page-break"></div>
                                    <div style="padding-top: 75px;">&nbsp;</div>
                                @endif
                                <table class="full-width-table" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td><span class="section-title">{{ $work->position_title }}</span></td>
                                        <td class="text-right"><span class="section-dates">{{ $work->position_start_date->format($date_format) }} &ndash; {{ $work->position_end_date ? $work->position_end_date->format($date_format) : 'Present' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><span class="section-title">{{ $work->position_company }}</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="section-summary">
                                            @foreach( $work->resumeDescriptions as $description )
                                                <p>
                                                    {{ $description->description }}
                                                </p>
                                            @endforeach
                                        </td>
                                    </tr>
                                </table>
                                <!-- This line will cleanly break a page -->
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

            @if ($educationSectionBreak)
                <div class="page-break"></div>
                <div style="padding-top: 75px;">&nbsp;</div>
            @endif
            <table class="full-width-table resume-section" align="center" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td><span class="section-heading">Education</span></td>
                    </tr>
                    @foreach( $resume->resumeEducations as $key=>$education )
                    <tr>
                        <td class="section-group">
                            <!-- This line will cleanly break a page -->
                            @if(in_array($key, $educationIndexBreaks))
                                <div class="page-break"></div>
                                <div style="padding-top: 75px;">&nbsp;</div>
                            @endif
                            <table class="full-width-table" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td><span class="section-title">{{ $education->school_name }} &ndash; {{ $education->degree_received }} {{ $education->field_of_study }}</span></td>
                                    <td class="text-right"><span class="section-dates">{{ $education->start_date->format($date_format) }} &ndash; {{ $education->end_date ? $education->end_date->format($date_format) : 'Present' }}</span></td>
                                </tr>
                                {{-- <tr>
                                    <td colspan="2" class="section-summary">
                                        @foreach( $education->educationDescriptions as $description )
                                            <p>{{ $description->description }}</p>
                                        @endforeach
                                    </td>
                                </tr> --}}
                            </table>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="full-width-table resume-section" align="center" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td><span class="section-heading">Skills</span></td>
                    </tr>
                    <tr>
                        <td class="section-summary">
                            @if(isset($resume->resumeSkill))
                                <ul>
                                    @foreach ($resume->resumeSkill as $skill)
                                        <li>{{ $skill->name }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="full-width-table resume-section" align="center" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td><span class="section-heading">Affiliations &amp; Hobbies</span></td>
                    </tr>
                    <tr>
                        <td class="section-summary">
                            @if(isset($resume->hobbies))
                                <ul>
                                    @foreach ($resume->hobbies as $hobbies)
                                        <li>{{ $hobbies->name }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </body>
</html>
