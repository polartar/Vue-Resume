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
                            <span class="resume-title">{{ $resume->user->full_name }}</span>
                        </td>
                        <td>
                            <span class="contact-info">
                                {{ $resume->first_address->city }}, {{ $resume->first_address->province }}
                                <br/>
                                @if($resume->user->user_phones->first())
                                    {{ $resume->user->user_phones->first()->phone_number }}
                                @endif
                                <br/>
                                {{ $resume->user->email }}
                                <br/>
                                LinkedIn URL (todo)
                            </span>
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
                                        <li>{{ $summary->name }}</li>
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
                        <td><span class="section-heading">Work Experience</span></td>
                    </tr>

                    @foreach( $resume->resumeWorkExperiences as $work )
                        <tr>
                            <td class="section-group">
                                <table class="full-width-table" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td><span class="section-title">{{ $work->position_title }}</span></td>
                                        <td class="text-right"><span class="section-dates">{{ $work->position_start_date}} &ndash; {{ $work->position_end_date ? $work->position_end_date : 'Present' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><span class="section-title">{{ $work->position_company }}</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="section-summary">
                                            <ul class="work-experience-description-list">
                                                @foreach( $work->resumeDescriptions as $description )
                                                    <li class="work-experience-description">
                                                        {{ $description->description }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

            <table class="full-width-table resume-section" align="center" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td><span class="section-heading">Education</span></td>
                    </tr>
                    @foreach( $resume->resumeEducations as $education )
                    <tr>
                        <td class="section-group">
                            <table class="full-width-table" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td><span class="section-title">{{ $education->school_name }} &ndash; {{ $education->degree_received }} {{ $education->field_of_study }}</span></td>
                                    <td class="text-right"><span class="section-dates">{{ $education->start_date}} &ndash; {{ $education->end_date ? $education->end_date : 'Present' }}</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="section-summary">
                                        @foreach( $education->educationDescriptions as $description )
                                            <p>{{ $description->description }}</p>
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="full-width-table" align="center" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td>

                        </td>
                    </tr>
                </tbody>
            </table>



            <span class="heading">Affiliations &amp; Hobbies</span>
            <br/>
        </div>
    </body>
</html>
