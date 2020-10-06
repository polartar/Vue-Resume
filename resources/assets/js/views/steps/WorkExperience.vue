<template>
    <div>
        <h3>
            Work Experience
            <small style="text-decoration: underline; cursor: pointer;" @click="show = !show">
                <span v-if="!show">Create</span><span v-else>See All Experience</span>
            </small>
        </h3>

        <div class='resume-step-form' v-if="show">
            <div class='grid-x grid-margin-x'>
                <div class='cell medium-6'>
                    <div class='form-group'>
                        <label>Job Title</label>
                        <input type='text' name='position_title' v-model='title'>
                    </div>
                </div>
                <div class='cell medium-6'>
                    <div class='form-group'>
                        <label>Company</label>
                        <input type='text' name='company' v-model='company'>
                    </div>
                </div>
                <div class='cell'>
                    <div class='form-group'>
                        <label>Description</label>
                        <textarea required name='summary' rows='8' cols='80' v-model='description'></textarea>
                    </div>
                </div>
                <div class='cell medium-6'>
                    <div class='form-group'>
                        <label>Start Date</label>
                        <input type='date' name='start_date' v-model='startDate'>
                    </div>
                </div>
                <div class='cell medium-6'>
                    <div class='form-group'>
                        <label>End Date</label>
                        <input type='date' name='end_date' v-model='endDate'>
                    </div>
                    <div class='form-group'>
                        <label><input type='checkbox' name='end_date_currently' v-model='currentEmployer'> Current
                            Employer</label>
                    </div>
                </div>
            </div>
            <button class='button' type='button' @click='addWorkExperience'>Add Work Experience</button>
        </div>
        <div class='resume-step-form' v-if="!show">
            <div class='grid-x grid-margin-x'>
                <div class="cell" v-for="workExperience in resume.resume_work_experiences">
                    <div class="card">
                        <div class="card-section">
                            <p class="float-left" style="margin-bottom: 0;">
                                {{ workExperience.position_title }} at {{ workExperience.position_company }},
                                <em>{{ workExperience.position_start_date }} to
                                    {{ workExperience.position_end_date ? workExperience.position_end_date : "present" }}</em>
                                <span v-if="workExperience.resume_descriptions.length > 0">
                                    <br/>
                                    {{ workExperience.resume_descriptions[0].description }}
                                </span>
                            </p>
                            <button class="button close-button float-right" @click="removeWorkExperience(workExperience.id)">X</button>
                        </div>
                    </div>
                </div>
                <div class="cell">
                    <button class="button" @click="$router.go(-1)" style="background-color: grey!important;">Back</button>
                    <router-link tag="button" class="button" to="education">Next</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'

    export default {
        computed: mapState([
            'resume',
        ]),

        data: function () {
            return {
                'title': '',
                'company': '',
                'startDate': '',
                'endDate': '',
                'description': '',
                'currentEmployer': false,
                'show': false,
            }
        },

        mounted() {},

        methods: {
            addWorkExperience: async function () {
                // Need to create a new resume description
                const workExperienceId = await this.createWorkExperience();
                await this.createResumeDescription(workExperienceId);
                this.show = false;
                this.$store.commit('reloadResume');
            },
            createResumeDescription: async function (workExperienceId) {
                await this.$axios
                    .post('/resume-description', {
                        'resume_work_experience_id': workExperienceId,
                        'description': this.description,
                        'type': 'paragraph',
                    })
                    .then(response => {
                        console.log(response);
                    })
                    .catch(error => {
                        console.log('error create resume description', error);
                    });
            },
            createWorkExperience: async function () {
                let id;
                await this.$axios
                    .post('/resume-work-experience', {
                        'resume_id': this.resume.id,
                        'position_title': this.title,
                        'position_company': this.company,
                        'position_start_date': this.startDate,
                        'position_end_date': this.endDate,
                        'current_employer': this.currentEmployer,
                    })
                    .then(response => {
                        id = response.data.id;
                        this.resetForm();
                        this.$toasted.show('Successfully added work experience!', {
                            position: 'bottom-center',
                            duration: 3000,
                            fullWidth: true,
                            type: 'success',
                        });
                    })
                    .catch(error => {
                        this.$toasted.show('Uh oh, we had some trouble with that.', {
                            position: 'bottom-center',
                            duration: 3000,
                            fullWidth: true,
                            type: 'error',
                        });
                    });
                return id;
            },
            removeWorkExperience: function (workExperienceId) {
                this.$axios.delete('/resume-work-experience/' + workExperienceId)
                    .then(response => {
                        this.$toasted.show('Successfully removed work experience!', {
                            position: 'bottom-center',
                            duration: 3000,
                            fullWidth: true,
                            type: 'success',
                        });
                        this.$store.commit('reloadResume');
                    })
                    .catch(error => {
                        this.$toasted.show('Uh oh, we had some trouble with that.', {
                            position: 'bottom-center',
                            duration: 3000,
                            fullWidth: true,
                            type: 'error',
                        });
                    });
            },
            resetForm: function () {
                this.title = '';
                this.company = '';
                this.startDate = '';
                this.endDate = '';
                this.description = '';
                this.currentEmployer = false;
            }
        }
    }
</script>
