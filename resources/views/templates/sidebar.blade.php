<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            {!! file_get_contents(asset('assets/css/resumes/sidebar.css')) !!}
        </style>
    </head>
    <body class="resume-pdf resume-sidebar">
        <div class="print-paper">
            <span class="name">{{ $resume->user->full_name }}</span>
            <hr/>
            <br/><br/>

            <div class="resume-content">
                <table class="full-width-table" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="width: 40%">
                                <div class="left">
                                    <span class="header">Contact</span>
                                    <hr/>

                                    @if($resume->user->user_phones->first())
                                        <span class="sub-header">Phone</span>
                                        <span>{{ $resume->user->user_phones->first()->phone_number }}</span>
                                    @endif

                                    <span class="sub-header">Email</span>
                                    <span>{{ $resume->user->email }}</span>
                                    <span class="sub-header">Website</span>
                                    <span>TODO: Make website form</span>
                                    <span class="sub-header">Address</span>
                                    <span>{{ $resume->first_address->street_1 }} {{ $resume->first_address->street_2 }}</span>
                                    <br/>
                                    <span>{{ $resume->first_address->city }}, {{ $resume->first_address->province }} {{ $resume->first_address->zip }}</span>
                                    <br/><br/>

                                    <span class="header">Skills</span>
                                    <hr/>
                                    List of Skill Here
                                    <br/>

                                    <span class="header">Education</span>
                                    <hr/>

                                    @foreach( $resume->resumeEducations as $education )
                                    <div>
                                        <span class="sub-sub-header">{{ $education->degree_received }}</span>
                                        {{ $education->school_name }}
                                        <br/>
                                        {{ $education->start_date }}-{{ $education->end_date ? $education->end_date : 'Present' }}
                                        <br/><br/>
                                    </div>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <div class="right">
                                    <div v-if="resume.resume_summaries[0]">
                                        <span class="header">Professional Summary</span>
                                        <hr/>
                                        @if(isset($resume->resume_summaries))
                                            <span>{{ $resume->resume_summaries->name }}</span>
                                        @endif
                                        <br/>
                                    </div>

                                    <span class="header">Work Experience</span>
                                    <hr/>

                                    @foreach( $resume->resumeWorkExperiences as $work )
                                        <div>
                                            <span class="sub-header">
                                                {{ $work->position_title }}
                                            </span>
                                            <span class="">
                                                {{ $work->position_company }} | {{ $work->position_start_date }}-{{ $work->position_end_date ? $work->position_end_date : 'Present' }}
                                            </span>
                                            <br/>
                                            @foreach( $work->resumeDescriptions as $description )
                                                <span>
                                                    {{ $description->description }}<br>
                                                </span>
                                            @endforeach

                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

        </div>
    </body>
</html>
