<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            {!! file_get_contents(asset('assets/css/resumes/functional.css')) !!}
        </style>
    </head>
    <body class="resume-pdf resume-functional">

        <div class="print-paper">
            <span class="resume-title">{{ $resume->user->fullName }}</span>
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
            <br/>

            @if(isset($resume->resume_summaries))
                <div v-if="resume.resume_summaries[0]">
                    <span class="heading">Summary</span>
                    @foreach ($resume->resume_summaries as $resume_summaries)
                        <span>{{ $resume_summaries->name }}</span><br/>
                    @endforeach
                </div>
            @endif

            <span class="heading">Work Experience</span>
            @foreach( $resume->resumeWorkExperiences as $work )
                <div v-for="work in resume.resume_work_experiences" class="section">
                    <span class="work-experience-title float-left">{{ $work->position_title }}</span>
                    <span class="work-experience-dates float-right">{{ $work->position_start_date}} to {{ $work->position_end_date ? $work->position_end_date : 'present' }}</span>
                    <br/>
                    <span class="work-experience-company">{{ $work->position_company }}</span>
                    <ul class="work-experience-description-list">
                        @foreach( $work->resumeDescriptions as $description )
                            <li class="work-experience-description">
                                {{ $description->description }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            <span class="heading">Education</span>
            @foreach( $resume->resumeEducations as $education )
                <div v-for="education in resume.resume_educations">
                    <span class="education-experience-title float-left">{{ $education->school_name }}</span>
                    <span class="education-experience-dates float-right">{{ $education->start_date}} to {{ $education->end_date ? $education->end_date : 'present' }}</span>
                   <br/>
                   <span v-if="$education->education_descriptions && $education->education_descriptions.length > 0">
                       {{ $education->education_descriptions }}
                   </span>
                    <br/>
                </div>
            @endforeach

            <span class="heading">Affiliations &amp; Hobbies</span>
            <br/>
        </div>

    </body>
</html>
