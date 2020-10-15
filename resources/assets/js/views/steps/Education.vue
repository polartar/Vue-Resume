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
                        <label>Description</label>
                        <textarea required v-model="summary" rows="8" cols="80"></textarea>
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
            <button v-if="edit" class="button" @click="toggleView" style="background-color: grey!important;">Cancel</button>
            <button v-if="edit" class='button' type='button' @click='updateEducation'>Update Education</button>
            <button v-else class="button" type="button" @click="createEducationExperience">Add Education</button>
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
                            </p>                            
                            <el-button class="float-right" type="danger" icon="el-icon-delete" circle @click="removeEducation(education.id)"></el-button>
                            <el-button class="float-right" type="primary" icon="el-icon-edit" circle @click="editEducation(education)"></el-button>
                        </div>
                    </div>
                </div>
                <div class="cell">
                    <button class="button" @click="$router.go(-1)" style="background-color: grey!important;">Back</button>
                    <router-link tag="button" class="button" to="skills">Next</router-link>
                </div>
            </div>
        </div>
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
                edit: false,
                editId: null,
                editDescriptionId: null,

                summary: '',
            }
        },

        mounted() {
            //
        },

        methods: {
            createEducationExperience: async function () {
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
                        this.createEducationDescription(response.data.id);
                        this.formReset();
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
            editEducation: function (education) {
                this.setupEditing(education);
                this.show = true;
                this.edit = true;
                this.editId = education.id;
                if (!! education.education_descriptions.length > 0)
                    this.editDescriptionId = education.education_descriptions[0].id;
            },
            updateEducation: async function () {
                this.$axios
                    .put('/resume-education/' + this.editId, {
                        'resume_id'                 : this.resume.id,
                        'school_name'               : this.schoolName,
                        'type'                      : this.type,
                        'degree_received'           : this.degreeReceived,
                        'field_of_study'            : this.fieldOfStudy,
                        'completed'                 : this.completed,
                        'start_date'                : this.startDate,
                        'end_date'                  : this.endDate,
                        'currently_studying'        : this.currentlyStudying,
                    })
                    .then(response =>  {
                        this.updateEducationDescription();
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
            updateEducationDescription: function () {
                this.$axios
                    .put(`/education-description/${this.editDescriptionId}`, {
                        'resume_education_id': this.editId,
                        'description': this.summary,
                        'type': 'paragraph',
                    })
                    .then(response => {
                        this.formReset();
                        this.show = false;
                        this.edit = false;
                        this.editId = null;
                        this.editDescriptionId = null;
                        this.$store.commit('reloadResume');
                        
                        this.$toasted.show('Successfully updated education experience!', {
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
                        console.log('error create education description', error);
                    });
            },
            setupEditing: function (education) {
                this.schoolName         = education.school_name
                this.type               = education.type
                this.degreeReceived     = education.degree_received
                this.fieldOfStudy       = education.field_of_study
                this.completed          = education.completed
                this.startDate          = education.start_date
                this.endDate            = education.end_date
                this.currentlyStudying  = education.currently_studying
                if (!! education.education_descriptions.length > 0)
                    this.summary = education.education_descriptions[0].description;
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
            createEducationDescription: function (resumeEducationId) {
                this.$axios
                    .post('/education-description', {
                        resume_education_id: resumeEducationId,
                        description: this.summary,
                    })
                    .then(response => {
                        this.$store.commit('reloadResume');
                        this.$toasted.show('Successfully added education!', {
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
                        console.log(error);
                        return;
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
            resetEditing: function () {
                this.edit = false;
                this.editId = null;
                this.editDescriptionId = null;
                this.formReset();
            },
            toggleView: function () {
                this.show = !this.show;
                this.resetEditing();
            },
        }
    }
</script>
