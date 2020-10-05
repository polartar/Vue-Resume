<template>
    <div class="print-paper">
        <span class="name">{{ fullName }}</span>
        <hr/>
        <br/><br/>
        <div class="resume-content">
            <div class="left">
                <span class="header">Contact</span>
                <hr/>
                <span class="sub-header">Phone</span>
                <span>{{ phone }}</span>
                <span class="sub-header">Email</span>
                <span>{{ email }}</span>
                <span class="sub-header">Website</span>
                <span>TODO: Make website form</span>
                <span class="sub-header">Address</span>
                <span>{{ street_1 }}{{ street_2 ? ", " + street_2 : ''}}</span>
                <br/>
                <span>{{ city }}, {{ province }} {{ zip }}</span>
                <br/><br/>

                <span class="header">Skills</span>
                <hr/>
                List of Skill Here
                <br/>

                <span class="header">Education</span>
                <hr/>

                <div v-for="education in resume.resume_educations">
                    <span class="sub-sub-header">{{ education.degree_received }}</span>
                    {{ education.school_name }}
                    <br/>
                    {{ education.start_date.substring(0,4) }}-{{ education.end_date ? education.end_date.substring(0,4) : 'Present' }}
                    <br/><br/>
                </div>
            </div>

            <div class="right">
                <div v-if="resume.resume_summaries[0]">
                    <span class="header">Professional Summary</span>
                    <hr/>
                    <span>{{ resume.resume_summaries[0].name }}</span>
                    <br/>
                </div>

                <span class="header">Work Experience</span>
                <hr/>

                <div v-for="work in resume.resume_work_experiences">
                    <span class="sub-header">
                        {{ work.position_title }}
                    </span>
                    <span class="">
                        {{ work.position_company }} | {{ work.position_start_date.substring(0,4) }}-{{ work.position_end_date ? work.position_end_date.substring(0,4) : 'Present' }}
                    </span>
                    <br/>
                    <span v-if="work.resume_descriptions[0]">
                        {{ work.resume_descriptions[0].description }}
                    </span>
                </div>
            </div>
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

<style scoped>
    @media print {
        body * {
            visibility: hidden;
        }
        .print-paper, .print-paper * {
            visibility: visible;
        }
        .print-paper {
            position: absolute;
            left: 0;
            top: 0;
        }
    }

    .print-paper {
        width: 794px;
        /*min-height: 100%;*/
        padding: 72px 72px 0 72px;
        background-color: white;
        font-family: Arial, sans-serif;
        font-size: 12pt;
        font-weight: normal;
    }

    .name {
        font-size: 36pt;
        display: block;
        text-align: center;
    }

    .resume-content {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .left {
        max-width: 40%;
        padding-right: 15px;
        border-right: black 2px solid;
        text-align: right;
    }

    .right {
        width: 60%;
        padding-left: 30px;
        text-align: left;
    }

    .header {
        font-size: 20pt;
        font-weight: bold;
    }

    .sub-header {
        font-size: 15pt;
        font-weight: bold;
        display: block;
    }

    .sub-sub-header {
        font-weight: bold;
        display: block;
    }
</style>

