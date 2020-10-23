<template>
    <div>
        <div class="resume-step-heading-container">
            <h3 class="resume-step-heading">
                Work Experience
                <small style="text-decoration: underline; cursor: pointer;" @click="toggleView">
                    <span v-if="!show || esume.resume_work_experiences.length === 0">Create</span><span v-else>Cancel</span>
                </small>
            </h3>
        </div>

        <div class='resume-step-form' v-if="show || (resume.resume_work_experiences && resume.resume_work_experiences.length === 0)">
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
                        <el-date-picker
                            v-model="startDate"
                            type="date"
                            format="yyyy/MM/dd"
                            value-format="yyyy-MM-dd"
                            placeholder="Pick a day">
                        </el-date-picker>
                    </div>
                    <br/>
                    <div class='form-group'>
                        <label><input type='checkbox' name='end_date_currently' v-model='currentEmployer'> Current
                            Employer</label>
                    </div>
                </div>
                <div class='cell medium-6'>
                    <div class='form-group'>
                        <label>End Date</label>
                        <el-date-picker
                            v-model="endDate"
                            type="date"
                            format="yyyy/MM/dd"
                            value-format="yyyy-MM-dd"
                            placeholder="Pick a day">
                        </el-date-picker>
                    </div>
                </div>
            </div>
            <button v-if="edit" class="button" @click="toggleView" style="background-color: grey!important;">Cancel</button>
            <button v-if="edit" class='button' type='button' @click='updateWorkExperience'>Update Work Experience</button>
            <button v-else class='button' type='button' @click='addWorkExperience'>Add Work Experience</button>
        </div>
        <div v-if="workExperienceList && workExperienceList.length > 0">
            <draggable v-model="workExperienceList" group="work-experiences" @start="drag=true" @end="drag=false" class="grid-x grid-margin-x" :sort="true">
                <div class="cell" v-for="workExperience in workExperienceList" :key="workExperience.order">
                    <div class="card">
                        <div class="card-section">
                            <p class="float-left" style="margin-bottom: 0;">
                                {{ workExperience.position_title }} at {{ workExperience.position_company }}
                                <br/>
                                <em>{{ workExperience.position_start_date }} to
                                    {{ workExperience.position_end_date ? workExperience.position_end_date : "present" }}</em>
                                <span v-if="workExperience.resume_descriptions && workExperience.resume_descriptions.length > 0">
                                    <br/>
                                    {{ workExperience.resume_descriptions[0].description }}
                                </span>
                            </p>
                            <el-button class="float-right" type="danger" icon="el-icon-delete" circle @click="removeWorkExperience(workExperience.id)"></el-button>
                            <el-button class="float-right" type="primary" icon="el-icon-edit" circle @click="editWorkExperience(workExperience)"></el-button>
                        </div>
                    </div>
                </div>
            </draggable>
        </div>
        <div class="resume-form-nav-buttons">
            <button class="button back-button" @click="$router.go(-1)"><font-awesome-icon aria-hidden="true"  class="fancy-select-icon" :icon="['fas', 'arrow-left']"></font-awesome-icon></button>
            <button class="button preview-button" @click="updateToggleResumePreview"><span v-if="toggleResumePreview">Stop </span>Preview</button>
            <router-link tag="button" class="button" to="education">Save &amp; Continue</router-link>
        </div>
    </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    import draggable from 'vuedraggable';

    export default {
        components: {draggable},

        computed: {
            ...mapState([
                'resume',
                'toggleResumePreview',
            ]),
            workExperienceList: {
                get() {
                    return this.$store.state.resume.resume_work_experiences;
                },
                async set(value) {
                    await this.$store.dispatch('updateResumeWorkExperienceOrder', value);
                }
            }
        },

        data: function () {
            return {
                'title': '',
                'company': '',
                'startDate': '',
                'endDate': '',
                'description': '',
                'currentEmployer': false,
                'show': false,
                'edit': false,
                'editId': null,
                'editDescriptionId': null,
            }
        },

        mounted() {},

        methods: {
            addWorkExperience: async function () {
                // Need to create a new resume description
                const workExperienceId = await this.createWorkExperience();
                await this.createResumeDescription(workExperienceId);
                this.resetForm();
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
                        //
                    })
                    .catch(error => {
                        console.log('error create resume description', error);
                    });
            },
            updateResumeDescription: function (resumeDescriptionId, workExperienceId) {
                this.$axios
                    .put(`/resume-description/${resumeDescriptionId}`, {
                        'resume_work_experience_id': workExperienceId,
                        'description': this.description,
                        'type': 'paragraph',
                    })
                    .then(response => {
                        //
                    })
                    .catch(error => {
                        console.log('error create resume description', error);
                    });
            },
            updateToggleResumePreview: function (event) {
                this.$store.commit('updateToggleResumePreview', !this.toggleResumePreview)
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
            editWorkExperience: function (workExperience) {
                this.setupEditing(workExperience);
                this.show = true;
                this.edit = true;
                this.editId = workExperience.id;
                if (!! workExperience.resume_descriptions.length > 0)
                    this.editDescriptionId = workExperience.resume_descriptions[0].id;
            },
            updateWorkExperience: function () {
                this.$axios
                    .put('/resume-work-experience/' + this.editId, {
                        'position_title': this.title,
                        'position_company': this.company,
                        'position_start_date': this.startDate,
                        'position_end_date': this.endDate,
                        'current_employer': this.currentEmployer,
                    })
                    .then(response => {
                        this.updateResumeDescription(this.editDescriptionId, this.editId);
                        this.resetForm();
                        this.show = false;
                        this.edit = false;
                        this.editId = null;
                        this.editDescriptionId = null;
                        this.$store.commit('reloadResume');
                        this.$toasted.show('Successfully updated work experience!', {
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
            setupEditing: function (workExperience) {
                this.editId = workExperience.id;
                this.title = workExperience.position_title;
                this.company = workExperience.position_company;
                this.startDate = workExperience.position_start_date;
                this.endDate = workExperience.position_end_date;
                if (workExperience.resume_descriptions.length > 0)
                    this.description = workExperience.resume_descriptions[0].description;
                this.currentEmployer = workExperience.current_employer;
            },
            resetForm: function () {
                this.title = '';
                this.company = '';
                this.startDate = '';
                this.endDate = '';
                this.description = '';
                this.currentEmployer = false;
            },
            resetEditing: function () {
                this.edit = false;
                this.editId = null;
                this.editDescriptionId = null;
                this.resetForm();
            },
            toggleView: function () {
                this.show = !this.show;
                this.resetEditing();
            },
        }
    }
</script>
<style scoped>
    .el-button {
        margin-right: 10px;
    }
    .el-input__inner {
        margin-bottom: 0!important;
    }
</style>

