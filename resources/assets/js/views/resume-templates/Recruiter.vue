<template>
    <div class="resume-html resume-recruiter">
        <div class="print-paper">
            <span class="resume-title">{{ fullName }}</span>
            <span class="contact-info">
                {{ city }}, {{ province }}
                <br/>
                {{ phone }}
                <br/>
                {{ email }}
                <br/>
                LinkedIn URL (todo)
            </span>
            <br/>

            <div v-if="resume.resume_summaries[0]">
                <span class="heading">Summary</span>
                <span>{{ resume.resume_summaries[0].name }}</span>
                <br/>
            </div>

            <span class="heading heading-bold">Techniques, Software & Instrumentation</span>
            <br/>

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

            <span class="heading">Affiliations &amp; Hobbies</span>
            <br/>
        </div>
    </div>
</template>

<script>
    import {mapState, mapGetters} from 'vuex'

    export default {
        computed: {
            ...mapState([
                'firstName',
                'lastName',
                'email',
                'phone',
                'street_1',
                'street_2',
                'city',
                'province',
                'zip',
                'country',
                'summary',
                'resume',
            ]),
            ...mapGetters([
                'resumeName',
                'resumeSummary',
                'fullName',
            ])
        },

        mounted() {},

        methods: {}
    }
</script>
