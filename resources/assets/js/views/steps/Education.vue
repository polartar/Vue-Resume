<template>
    <div>
        <h3>
            Education
            <small style="text-decoration: underline; cursor: pointer;" @click="show = !show">
                <span v-if="!show">Create</span><span v-else>See All Experience</span>
            </small>
        </h3>

        <div class="resume-step-form" v-if="show">
            <div class="grid-x grid-margin-x">
                <div class="cell medium-6">
                    <div class="form-group">
                        <label>School</label>
                        <input type="text" name="school" v-model="schoolName">
                    </div>
                </div>
                <div class="cell medium-6">
                    <div class="form-group">
                        <label>School Type</label>
                        <select v-model="type" class="fancy-select">
                            <option disabled selected>--Choose--</option>
                            <option v-for="schoolType in types" :value="schoolType">
                                {{ schoolType }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="cell medium-6">
                    <div class="form-group">
                        <label>Degree</label>
                        <input type="text" name="degree" v-model="degreeReceived">
                    </div>
                </div>
                <div class="cell medium-6">
                    <div class="form-group">
                        <label>Field of Study</label>
                        <input type="text" name="field_of_study" v-model="fieldOfStudy">
                    </div>
                </div>

                <div class="cell">
                    <div class="form-group">
                        <label>Description (temporarily out of order)</label>
                        <textarea required name="summary" rows="8" cols="80"></textarea>
                    </div>
                </div>
                <div class="cell medium-6">
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start_date" v-model="startDate">
                    </div>
                </div>
                <div class="cell medium-6">
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" name="end_date" v-model="endDate">
                    </div>
                    <div class="form-group">
                        <label><input type="checkbox" name="currently_studying" v-model="currentlyStudying">Currently Studying</label>
                    </div>
                    <div class="form-group">
                        <label><input type="checkbox" name="completed" v-model="completed">Completed Degree</label>
                    </div>
                </div>
            </div>
            <button class="button" type="button" @click="createEducationExperience">Add Education</button>
        </div>
        <div class='resume-step-form' v-if="!show">
            <div class='grid-x grid-margin-x'>
                <div class="cell" v-for="education in resume.resume_educations">
                    <div class="card">
                        <div class="card-section">
                            <p class="float-left" style="margin-bottom: 0;">
                                {{ education.school_name }} - {{ education.type }}
                                <br/>
                                <em>
                                    {{ education.start_date }} to
                                    {{ education.end_date ? education.end_date : "present" }}
                                </em>
                                <br/>
                                {{ education.degree_received }} in {{ education.field_of_study }}
<!--                                <span v-if="education.resume_descriptions.length > 0">-->
<!--                                    <br/>-->
<!--                                    {{ education.resume_descriptions[0].description }}-->
<!--                                </span>-->
                            </p>
                            <button class="button close-button float-right" @click="removeEducation(education.id)">X</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="button" @click="next">Next</button>
    </div>
</template>

<script>
    import {mapGetters, mapState} from 'vuex'

    export default {
        computed: {
            ...mapGetters([
                'resumeId'
            ]),
            ...mapState([
                'resume'
            ])
        },

        data: function () {
            return {
                schoolName: '',
                type: '',
                types: [
                    'high school',
                    'trade / vocation',
                    'community college',
                    'university'
                ],
                degreeReceived: '',
                fieldOfStudy: '',
                completed: false,
                startDate: null,
                endDate: null,
                currentlyStudying: false,
                show: false,
            }
        },

        mounted() {
            //
        },

        methods: {
            createEducationExperience: function () {
                this.$axios
                    .post('/resume-education', {
                        resume_id: this.resumeId,
                        school_name: this.schoolName,
                        type: this.type,
                        degree_received: this.degreeReceived,
                        field_of_study: this.fieldOfStudy,
                        completed: this.completed,
                        start_date: this.startDate,
                        end_date: this.endDate,
                        currently_studying: this.currentlyStudying,
                    })
                    .then(response => {
                        this.show = false;
                        this.formReset();
                        this.$toasted.show('Successfully added education!', {
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
            removeEducation: function (educationId) {
                this.$axios.delete('/resume-education/' + educationId)
                    .then(response => {
                        this.$toasted.show('Successfully removed education!', {
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
            formReset: function () {
                this.schoolName = '';
                this.type = '';
                this.degreeReceived = '';
                this.fieldOfStudy = '';
                this.completed = false;
                this.startDate = null;
                this.endDate = null;
                this.currentlyStudying = false;
            },
            next: function () {
                this.$router.push({name: 'skills'});
            }
        }
    }
</script>
