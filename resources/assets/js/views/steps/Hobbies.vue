<template>
    <div>
        <div class="resume-step-heading-container">
            <h3 class="resume-step-heading">
                Hobbies and Affiliations
                <small style="text-decoration: underline; cursor: pointer;" @click="show = !show">
                    <span v-if="!show">Add</span><span v-else>Cancel</span>
                </small>
            </h3>
        </div>

        <div class='resume-step-form' v-if="show">
            <div class='grid-x grid-margin-x'>
                <div class='cell'>
                    <div class='form-group'>
                        <label>Hobby or Affiliation</label>
                        <textarea rows='8' cols='80' v-model='hobbyString' />
                    </div>
                </div>
            </div>
            <button v-if="edit" class='button' type='button' @click='updateHobby'>UpdateHobby or Affiliation </button>
            <button v-if="edit" class='button' type='button' @click='show = !show'>Cancel</button>
            <button v-else class='button' type='button' @click='saveHobby'>Add Hobby or Affiliation </button>
        </div>
        <div>
            <draggable v-model="hobbies" group="resume-hobbies" @start="drag=true" @end="drag=false" class="grid-x grid-margin-x" :sort="true">
                <div class="cell grabbable" v-for="hobby in hobbies" :key="hobby.id">
                    <div class="card">
                        <div class="card-section">
                            <p class="float-left" style="margin-bottom: 0;">
                                {{ hobby.name }}
                            </p>
                            <el-button class="float-right" type="danger" icon="el-icon-delete" circle @click="removeHobby(hobby.id)"></el-button>
                            <el-button class="float-right" type="primary" icon="el-icon-edit" circle @click="editHobby(hobby.id)"></el-button>
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
             <button class="button"  @click="moveNext">Continue</button>
        </div>
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex'
    import draggable from 'vuedraggable'
    import ConfirmModal from "../../components/ConfirmDialog";

    export default {
        components: {
            draggable,
            ConfirmModal
        },
        computed: {
            ...mapState([
                'resume',
                'toggleResumePreview',
                'refreshPreview',
            ]),
            hobbies: {
                get() {
                    return this.$store.state.resume.hobbies;
                },
                async set(value) {
                    await this.$store.dispatch('updateResumeHobbiesOrder', value);
                    // await this.updateRefreshPreview()
                }
            },
        },
        data: function () {
            return {
                hobbyString: '',
                show: false,
                edit: false,
                editId: '',
                drag: false,
                isProcess: false
            }
        },
        methods: {
            saveHobby: async function () {
                
                if(this.isProcess) return;
                    this.isProcess  = true;
                const success = await this.$store.dispatch('axiosPostRequest', {
                    route: '/hobby',
                    payload: {
                        resume_id: this.$store.state.resume.id,
                        name: this.hobbyString,
                        order: this.hobbies.length + 1,
                    },
                    commits: ['reloadResume'],
                    successMessage: 'Successfully added item',
                });
                
                if(success){
                    this.hobbyString = '';
                    await this.updateRefreshPreview()
                }
               
                this.isProcess = false;
            },
            updateHobby: async function () {
                if(this.isProcess) return;
                    this.isProcess  = true;
                this.show = false;
                
                 const success = await this.$store.dispatch('axiosPutRequest', {
                    route: '/hobby/' + this.editId,
                    payload: {
                        name: this.hobbyString,
                     },
                    successMessage: 'Successfully updated',
                    commits: ['reloadResume'],
                });

                if (success) {
                    this.name = '';
                    this.edit = false;
                    await this.updateRefreshPreview()
                }
                 this.isProcess = false;
            },
            updateToggleResumePreview: function (event) {
                this.$store.commit('updateToggleResumePreview', !this.toggleResumePreview)
            },
            editHobby: function (hobbyId) {
                this.hobbyString = this.resume.hobbies.find(obj => obj.id === hobbyId).name;
                this.edit = true;
                this.editId = hobbyId;
                this.show = true;
            },
            removeHobby: async function (hobbyId) {
                if(this.isProcess) return;
                    this.isProcess = true;
                const success = await this.$store.dispatch('axiosDeleteRequest', {
                    route: '/hobby/' + hobbyId,
                    payload: {},
                    successMessage: 'Successfully removed',
                    commits: ['reloadResume'],
                });
                if(success)
                    await this.updateRefreshPreview()

                this.isProcess = false;
            },
            updateRefreshPreview: function (event) {
                this.$store.commit('updateRefreshPreview')
            },
             moveNext(){
                if(this.show){
                     this.$refs.confirm
                        .show()
                        .then(() => {
                            this.$router.push("customize-design");
                        })
                        .catch(() => {
                        
                        });  
                }else{
                    this.$router.push("customize-design");
                }
                
            }
        }
    }
</script>
<style scoped>
    .el-button {
        margin-right: 10px;
    }
</style>
