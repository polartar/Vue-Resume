<template>
    <div>
        <div class="resume-step-heading-container">
            <h3 class="resume-step-heading">
                Education
                <small style="text-decoration: underline; cursor: pointer;" @click="toggleView">
                    <span v-if="!show || (resume.resume_educations && (resume.resume_educations.length == 0 || resume.resume_educations[0].id==='new'))">Add</span><span v-else>Cancel</span>
                </small>
            </h3>
        </div>

        <div class="resume-step-form" v-if="show || (resume.resume_educations && (resume.resume_educations.length===0 || resume.resume_educations[0].id==='new') )">
            <div class="grid-x grid-margin-x">
                <div class="cell medium-6">
                    <div class="form-group">
                        <label>School</label>
                        <input type="text" name="school" v-model="schoolName" @input='onChangeEducation'>
                    </div>
                </div>
                <div class="cell medium-6 ">
                    <div class="form-group hide">
                        <label>School Type</label>
                        <div class="fancy-select fancy-select-full-width">
                            <font-awesome-icon aria-hidden="true"  class="fancy-select-icon" :icon="['fas', 'caret-down']"></font-awesome-icon>
                            <select v-model="type" class="fancy-select" @input='onChangeEducation'>
                                <option disabled selected>--Choose--</option>
                                <option v-for="schoolType in types" :value="schoolType" :key="schoolType">
                                    {{ schoolType }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="cell medium-6">
                    <div class="form-group">
                        <label>Degree</label>
                        <input placeholder="PhD" type="text" name="degree" v-model="degreeReceived" @input='onChangeEducation'>
                    </div>
                </div>
                <div class="cell medium-6">
                    <div class="form-group">
                        <label>Field of Study</label>
                        <input placeholder="Chemistry" type="text" name="field_of_study" v-model="fieldOfStudy" @input='onChangeEducation'>
                    </div>
                </div>

                <div class="cell medium-6">
                    <div class="form-group">
                        <label>Start Date</label>
                        <el-date-picker
                            v-model="startDate"
                            type="date"
                            format="yyyy/MM/dd"
                            value-format="yyyy-MM-dd"
                            placeholder="Pick a day"
                            @input='onChangeEducation'
                            >
                        </el-date-picker>
                    </div>
                    <br/>
                    <div class="form-group hide">
                        <label><input type="checkbox" name="currently_studying" v-model="currentlyStudying" @input='onChangeEducation'> Currently Studying</label>
                    </div>
                </div>
                <div class="cell medium-6">
                    <div class="form-group">
                        <label>End Date</label>
                        <el-date-picker
                            v-model="endDate"
                            type="date"
                            format="yyyy/MM/dd"
                            value-format="yyyy-MM-dd"
                            placeholder="Pick a day"
                            @input='onChangeEducation'
                            >
                        </el-date-picker>
                    </div>
                    <br/>
                    <div class="form-group hide">
                        <label><input type="checkbox" name="completed" v-model="completed" @input='onChangeEducation'> Completed Degree</label>
                    </div>
                </div>
            </div>
            <button v-if="edit" class="button" @click="toggleView" style="background-color: grey!important;">Cancel</button>
            <button v-if="edit" class='button' type='button' @click='updateEducation'>Update Education</button>
            <button v-else class="button" type="button" @click="createEducationExperience">Add Education</button>
        </div>
        <div v-if="educationList && educationList.length > 0">
            <draggable v-model="educationList" group="work-experiences" @start="drag=true" @end="drag=false" class='grid-x grid-margin-x'>
                <div class="cell grabbable" v-for="education in educationList" :key="education.id">
                    <div class="card">
                        <div class="card-section">
                            <p class="float-left" style="margin-bottom: 0;">
                                <i class="el-icon-s-grid" style="color: #ffffff00;"></i> {{ education.school_name }} - {{ education.type }}
                                <br/>
                                <em>
                                    <i class="el-icon-s-grid" style="color: lightgrey;"></i> {{ education.start_date }} to
                                    {{ education.end_date ? education.end_date : "present" }}
                                </em>
                                <br/>
                                <i class="el-icon-s-grid" style="color: #ffffff00;"></i> {{ education.degree_received }} in {{ education.field_of_study }}
                            </p>
                            <el-button v-if="education.id!=='new'" class="float-right" type="danger" icon="el-icon-delete" circle @click="removeEducation(education.id)"></el-button>
                            <el-button v-if="education.id!=='new'" class="float-right" type="primary" icon="el-icon-edit" circle @click="editEducation(education)"></el-button>
                        </div>
                    </div>
                </div>
            </draggable>
        </div>
         <confirm-modal title="Are you sure you want to continue without saving?" ref="confirm">
        </confirm-modal>
        <div class="resume-form-nav-buttons">
            <button class="button back-button" @click="$router.go(-1)"><font-awesome-icon aria-hidden="true"  class="fancy-select-icon" :icon="['fas', 'arrow-left']"></font-awesome-icon></button>
            <button class="button preview-button" @click="updateToggleResumePreview"><span v-if="toggleResumePreview">Stop </span>Preview</button>
            <button class="button"   @click="moveNext">Continue</button>
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapState} from 'vuex'
    import draggable from 'vuedraggable';
    import ConfirmModal from "../../components/ConfirmDialog";
    export default {
        components: {
            draggable,
            ConfirmModal
        },

        computed: {
            ...mapGetters([
                'resumeId'
            ]),
            ...mapState([
                'resume',
                'toggleResumePreview',
                'refreshPreview',
            ]),
            educationList: {
                get() {
                    return this.$store.state.resume.resume_educations;
                },
                async set(value) {
                    await this.$store.dispatch('updateResumeEducationOrder', value);
                }
            }
        },

        data: function () {
            return {
                schoolName: '',
                type: 'high school',
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
                editId: "new",
                editDescriptionId: null,
                originalEducation: null,
                summary: '',
            }
        },

        mounted() {
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
                        //this.createEducationDescription(response.data.id);
                        this.$store.commit('reloadResume');
                        this.$notify.success({
                            title: 'Success',
                            message: 'Successfully updated education experience!',
                        });
                        this.formReset();
                        this.updateRefreshPreview()
                    })
                    .catch(error => {
                        this.$notify.error({
                            title: 'Error',
                            message: 'Uh oh, we had some trouble with that'
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
                        //this.updateEducationDescription();
                        this.$store.commit('reloadResume');
                        this.$notify.success({
                            title: 'Success',
                            message: 'Successfully updated education experience!',
                        });
                        this.formReset();
                        this.show = false;
                        this.updateRefreshPreview()
                    })
                    .catch(error => {
                        this.$notify.error({
                            title: 'Error',
                            message: 'Uh oh, we had some trouble with that'
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

                        this.$notify.success({
                            title: 'Success',
                            message: 'Successfully updated education experience!',
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
            updateToggleResumePreview: function (event) {
                 this.$store.commit('updateToggleResumePreview', !this.toggleResumePreview)
            },
            updateRefreshPreview: function (event) {
                 this.$store.commit('updateRefreshPreview')
            },
            setupEditing: function (education) {
                this.originalEducation  = education;
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
                        this.$notify.success({
                            title: 'Success',
                            message: 'Successfully removed education experience',
                        });
                        this.$store.commit('reloadResume');
                        // this.updateRefreshPreview()
                    })
                    .catch(error => {
                        this.$notify.error({
                            title: 'Error',
                            message: 'Uh oh, we had some trouble with that'
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
                        this.$notify.success({
                            title: 'Success',
                            message: 'Successfully added education experience!',
                        });
                        this.summary = '';
                        this.updateRefreshPreview()
                    })
                    .catch(error => {
                        this.$notify.error({
                            title: 'Error',
                            message: 'Uh oh, we had some trouble with that'
                        });
                        return;
                    });
            },
            formReset: function () {
                this.schoolName = '';
                // this.type = 'hight school';
                this.degreeReceived = '';
                this.fieldOfStudy = '';
                // this.completed = false;
                this.startDate = null;
                this.endDate = null;
                // this.currentlyStudying = false;
            },
            resetEditing: function () {
                this.edit = false;
                this.editId = "new";
                this.editDescriptionId = null;
                this.summary = '';
                this.formReset();
            },
            toggleView: function () {
                if(this.show){
                   if(this.edit) {
                      this.$store.commit("updateCurrentResumeEducation", this.originalEducation)    
                   }else{
                       this.$store.commit("deleteNewResumeEducation");
                   }
                }
                this.show = !this.show;
                this.resetEditing();
               
            },
            moveNext(){
                if(this.show || (this.resume.resume_educations && this.resume.resume_educations.length) == 0){
                     this.$refs.confirm
                        .show()
                        .then(() => {
                            this.$router.push({ name: 'skills', query: this.$route.query });
                        })
                        .catch(() => {
                        
                        });  
                }else{
                    this.$router.push({ name: 'skills', query: this.$route.query });
                }
                
            },
            onChangeEducation(e){
                this.$store.commit("updateCurrentResumeEducation", {
                    id: this.editId,
                    school_name: this.schoolName,
                    type: this.type,
                    degree_received: this.degreeReceived,
                    field_of_study: this.fieldOfStudy,
                    completed: this.completed,
                    start_date: this.startDate,
                    end_date: this.endDate,
                    currently_studying: this.currentlyStudying,
                })    
            }
        }
    }
</script>
<style scoped>
    .grabbable {
        cursor: grab;
    }
</style>
