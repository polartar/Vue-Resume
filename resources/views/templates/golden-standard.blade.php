<html>
    <head>

    </head>
    <body>
        <div class="print-paper">
            <span class="resume-title">{{ $resume->user->full_name }}</span>
            <span class="contact-info">
                {{ $resume->first_address->city }}, {{ $resume->first_address->province }}
                <br/>
                Phone Number
                <br/>
                {{ $resume->user->email }}
                <br/>
                LinkedIn URL (todo)
            </span>
            <br/>

            @if(isset($resume->resume_summaries))
            <div>
                <span class="heading">Summary</span>
                <span>{{ $resume->first_resume_summary->name }}</span>
                <br/>
            </div>
            @endif
            {{--
            <span class="heading">Work Experience</span>
            <div v-for="work in resume.resume_work_experiences" class="section">
                <span class="work-experience-title float-left">{{ work.position_title }}</span>
                <span class="work-experience-dates float-right">{{ work.position_start_date}} to {{ work.position_end_date ? work.position_end_date : 'present' }}</span>
                <br/>
                <span class="work-experience-company">{{ work.position_company }}</span>
                <ul class="work-experience-description-list">
                    <li v-for="description in work.resume_descriptions" class="work-experience-description">
                        {{ description.description }}
                    </li>
                </ul>
            </div>

            <span class="heading">Education</span>
            <div v-for="education in resume.resume_educations">
                <span class="education-experience-title float-left">{{ education.school_name }}</span>
                <span class="education-experience-dates float-right">{{ education.start_date}} to {{ education.end_date ? education.end_date : 'present' }}</span>
    <!--            <br/>-->
    <!--            <span v-if="education.resume_descriptions.length > 0">-->
    <!--                {{ education.resume_descriptions[0].description }}-->
    <!--            </span>-->
                <br/>
            </div>

            --}}

            <span class="heading">Affiliations &amp; Hobbies</span>
            <br/>
        </div>
    </body>
</html>