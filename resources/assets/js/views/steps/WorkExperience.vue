<template>
    <div>
        <div class="resume-step-heading-container">
            <h3 class="resume-step-heading">
                {{getHeaderTitle()}}
                <small style="text-decoration: underline; cursor: pointer;" @click="toggleView">
                    <span v-if="!show || (resume.resume_work_experiences && resume.resume_work_experiences.length === 0)">Add</span><span v-else>Cancel</span>
                </small>
            </h3>
        </div>

        <div class='resume-step-form' v-if="show || (resume.resume_work_experiences && resume.resume_work_experiences.length === 0)">
            <div class='grid-x grid-margin-x'>
                <div class='cell medium-6'>
                    <div class='form-group'>
                        <label>{{getTitle()}}</label>
                        <input type='text' name='position_title' v-model='title' @input="onEditWorkExperience">
                    </div>
                </div>
                <div class='cell medium-6'>
                    <div class='form-group'>
                        <label>{{getCompany}}</label>
                        <input type='text' name='company' v-model='company' @input="onEditWorkExperience">
                    </div>
                </div>
                <div class='cell'>
                    <div class='form-group'>
                        <label>Description</label>
                        <textarea required name='summary' rows='8' cols='80' v-model='description' @input="onEditWorkExperience"></textarea>
                    </div>
                </div>
                <div class='cell medium-6' v-if="resume.resume_design && resume.resume_design.name!=='Functional'">
                    <div class='form-group'>
                        <label>Start Date</label>
                        <el-date-picker
                            v-model="startDate"
                            type="date"
                            format="yyyy/MM/dd"
                            value-format="yyyy-MM-dd"
                            placeholder="Pick a day"
                            @input="onEditWorkExperience"
                            >
                        </el-date-picker>
                    </div>
                    <br/>
                    <div class='form-group'  v-if="resume.resume_design&&resume.resume_design.name!=='Functional'">
                        <label><input type='checkbox' name='end_date_currently' v-model='currentEmployer'> Current
                            Employer</label>
                    </div>
                </div>
                <div class='cell medium-6'  v-if="resume.resume_design&&resume.resume_design.name!=='Functional'">
                    <div class='form-group'>
                        <label>End Date</label>
                        <el-date-picker
                            v-model="endDate"
                            type="date"
                            format="yyyy/MM/dd"
                            value-format="yyyy-MM-dd"
                            placeholder="Pick a day"
                            @input="onEditWorkExperience"
                            >
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
                <div class="cell grabbable" v-for="workExperience in workExperienceList" :key="workExperience.id">
                    <div class="card">
                        <div class="card-section">
                            <p style="margin-bottom: 0; display: inline-block; max-width: 70%;">
                                <span style="display: block; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"><i class="el-icon-s-grid" style="color: #ffffff00;"></i> {{ workExperience.position_title }} at {{ workExperience.position_company }}</span>
                                <i class="el-icon-s-grid" style="color: lightgrey;"></i> <em>{{ workExperience.position_start_date }} to
                                    {{ workExperience.position_end_date ? workExperience.position_end_date : "present" }}</em>
                                <br/>
                                <span v-if="workExperience.resume_descriptions && workExperience.resume_descriptions.length > 0" style="display: block; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                    <i class="el-icon-s-grid" style="color: #ffffff00;"></i> {{ workExperience.resume_descriptions[0].description }}
                                </span>
                            </p>
                            <el-button class="float-right" type="danger" icon="el-icon-delete" circle @click="removeWorkExperience(workExperience.id)"></el-button>
                            <el-button class="float-right" type="primary" icon="el-icon-edit" circle @click="editWorkExperience(workExperience)"></el-button>
                        </div>
                    </div>
                </div>
            </draggable>
        </div>
        <confirm-modal title="Are you going to continue without save?" ref="confirm">
        </confirm-modal>
        <div class="resume-form-nav-buttons">
            <button class="button back-button" @click="$router.go(-1)"><font-awesome-icon aria-hidden="true"  class="fancy-select-icon" :icon="['fas', 'arrow-left']"></font-awesome-icon></button>
            <button class="button preview-button" @click="updateToggleResumePreview"><span v-if="toggleResumePreview">Stop </span>Preview</button>
            <button class="button" to="education" @click="moveNext">Continue</button>
        </div>
    </div>
    
</template>

<script>
    import {mapState} from 'vuex';
    import draggable from 'vuedraggable';
    import ConfirmModal from "../../components/ConfirmDialog";

    export default {
        components: {draggable, ConfirmModal},

        computed: {
            ...mapState([
                'resume',
                'toggleResumePreview',
                'refreshPreview',
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
                'editId': "new",
                'editDescriptionId': null,
                originalWorkExperience: null,
            }
        },

        mounted() {},

        methods: {
            /* Work Experiences */
            addWorkExperience: async function () {
                                        
                 //check validation
                if(!this.title){
                    this.$notify.error({ 
                          title: 'Error',
                          message: 'You should input the Job Title',
                        });
                    return;
                }

                if(this.resume.resume_design.name !== "Functional")
                {
                    if(!this.startDate){
                        this.$notify.error({ 
                            title: 'Error',
                            message: 'You should input the Start Date',
                            });
                        return;
                    }
                    if(!this.currentEmployer && !this.endDate){
                        this.$notify.error({ 
                            title: 'Error',
                            message: 'You should input the End Date',
                            });
                        return;
                    }
                    if(this.startDate >=  this.endDate){
                        this.$notify.error({ 
                            title: 'Error',
                            message: 'Please input valid start and end dates',
                            });
                        return;
                    }
                }
                

                // Need to create a new resume description
                const workExperienceId = await this.createWorkExperience();
                if(workExperienceId) {
                    await this.createResumeDescription(workExperienceId);
                    this.resetForm();
                    this.show = false;
                    this.$store.commit('reloadResume');
                    
                }
            },
            createWorkExperience: async function () {
                let id = false;
                await this.$axios
                    .post('/resume-work-experience', {
                        'resume_id': this.resume.id,
                        'position_title': this.title,
                        'position_company': this.company,
                        'position_start_date': this.startDate?this.startDate:'2021-01-01',
                        'position_end_date': this.endDate?this.endDate:'2021-01-01',
                        'current_employer': this.currentEmployer,
                    })
                    .then(response => {
                        id = response.data.id;
                        this.$notify.success({
                            title: 'Success',
                            message: 'Successfully added work experience!',
                        });

                        this.updateRefreshPreview()
                    })
                    .catch(error => {
                        this.$notify.error({
                            title: 'Error',
                            message: 'Uh oh, we had some trouble with that'
                        });
                    });
                return id;
            },
            updateWorkExperience: function () {
                this.updateResumeDescription(this.editDescriptionId, this.editId);
                this.$axios
                    .put('/resume-work-experience/' + this.editId, {
                        'position_title': this.title,
                        'position_company': this.company,
                        'position_start_date': this.startDate,
                        'position_end_date': this.endDate,
                        'current_employer': this.currentEmployer,
                    })
                    .then(response => {
                        this.resetForm();
                        this.show = false;
                        this.edit = false;
                        this.editId = null;
                        this.editDescriptionId = null;
                        this.$store.commit('reloadResume');
                        this.$notify.success({
                            title: 'Success',
                            message: 'Successfully updated work experience!',
                        });
                        this.updateRefreshPreview()
                    })
                    .catch(error => {
                        this.$notify.error({
                            title: 'Error',
                            message: 'Uh oh, we had some trouble with that'
                        });
                    });
            },
            removeWorkExperience: function (workExperienceId) {
                this.$axios.delete('/resume-work-experience/' + workExperienceId)
                    .then(response => {
                        this.$notify.success({
                            title: 'Success',
                            message: 'Successfully removed work experience!',
                        });
                        this.$store.commit('reloadResume');
                        this.updateRefreshPreview()
                    })
                    .catch(error => {
                        this.$notify.error({
                            title: 'Error',
                            message: 'Uh oh, we had some trouble with that'
                        });
                    });
            },

            /* Resume Descriptions for Work Experience */
            createResumeDescription: async function (workExperienceId) {
                if(this.description) {
                    await this.$axios
                        .post('/resume-description', {
                            'resume_work_experience_id': workExperienceId,
                            'description': this.description,
                            'type': 'paragraph',
                        })
                        .then(response => {
                            this.updateRefreshPreview()
                        })
                        .catch(error => {
                            //
                        });
                }
            },
            updateResumeDescription: function (resumeDescriptionId, workExperienceId) {
                if(this.description) {
                    if (!resumeDescriptionId) { // Need to create a new resume description in this case
                        this.createResumeDescription(workExperienceId);
                        return;
                    }

                    this.$axios
                        .put(`/resume-description/${resumeDescriptionId}`, {
                            'resume_work_experience_id': workExperienceId,
                            'description': this.description,
                            'type': 'paragraph',
                        })
                        .then(response => {
                            this.updateRefreshPreview()
                        })
                        .catch(error => {
                            console.log('error create resume description', error);
                        });
                }
            },

            /* Actions */
            editWorkExperience: function (workExperience) {
                this.setupEditing(workExperience);
                this.show = true;
                this.edit = true;
                this.editId = workExperience.id;
                if (!! workExperience.resume_descriptions.length > 0)
                    this.editDescriptionId = workExperience.resume_descriptions[0].id;
            },
            setupEditing: function (workExperience) {
                this.originalWorkExperience = workExperience;
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
                this.editId = "new";
                this.editDescriptionId = null;
                this.resetForm();
            },
            toggleView: function () {
               if(this.show){
                   if(this.edit) {
                      this.$store.commit("updateCurrentResumeWorkExperience", this.originalWorkExperience)    
                   }else{
                       this.$store.commit("deleteNewWorkExperience");
                   }
                }
                this.show = !this.show;
                this.resetEditing();
            },
            updateToggleResumePreview: function (event) {
                this.$store.commit('updateToggleResumePreview', !this.toggleResumePreview)
            },
            updateRefreshPreview: function (event) {
                this.$store.commit('updateRefreshPreview')
            },
            moveNext(){
                if(this.show){
                     this.$refs.confirm
                        .show()
                        .then(() => {
                            this.$router.push("education");
                        })
                        .catch(() => {
                        
                        });  
                }else{
                    this.$router.push("education");
                }
                
            },

            onEditWorkExperience(){
                this.$store.commit('updateCurrentResumeWorkExperience', {
                        id: this.editId, 
                        title: this.title, 
                        company: this.company, 
                        description: 
                        this.description,
                        start_date: this.startDate,
                        end_date: this.endDate
                    }
                )
            },

            getTitle(){
                if(!this.resume.resume_design) return

                if(this.resume.resume_design.name === 'Functional')
                    return "Transferable or Technical Skill";
                else 
                    return "Title"
            },

            getCompany(){
                if(!this.resume.resume_design) return

                 if(this.resume.resume_design.name === 'Combination')
                    return "Company or Institution"
                else 
                    return "Company"
            },
             
            getHeaderTitle(){
                if(!this.resume.resume_design) return

                if(this.resume.resume_design.name === 'Combination')
                    return "Relavant Work Experience";
                else
                    return "Work Experience"
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
    .grabbable {
        cursor: grab;
    }
</style>
