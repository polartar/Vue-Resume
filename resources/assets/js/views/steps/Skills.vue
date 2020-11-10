<template>
    <div>

        <div class="resume-step-heading-container">
            <h3 class="resume-step-heading">Skills</h3>
        </div>

        <div class="resume-step-form">
            <div class="grid-x grid-margin-x">

                <div class="cell medium-10">
                    <div class="form-group">
                        <label>Skill <span class="label-optional-text">Press enter to add</span></label>
                        <input type="text" v-model="skillString" placeholder="Enter a skill" @keyup.enter="addSkill()" />
                    </div>
                </div>
                <div class="cell medium-2">
                    <el-button type="primary" style="margin-top: 25px;" circle @click="addSkill()">⏎</el-button>
                </div>

                <div class="cell">
                    <draggable v-model="skills" group="skills" @start="drag=true" @end="drag=false" class='grid-x grid-margin-x'>
                        <div class="cell grabbable" v-for="skill in skills" :key="skill.id">
                            <div class="card" style="padding: 12px!important;">
                                <div class="card-section">
                                    <p class="float-left" style="margin-bottom: 0;">
                                        <i class="el-icon-s-grid" style="color: lightgrey;"></i> {{ skill.name }}
                                    </p>
                                    <el-button class="float-right" type="danger" icon="el-icon-delete" circle @click="removeSkill(skill.id)"></el-button>
                                </div>
                            </div>
                        </div>
                    </draggable>
                </div>


            </div>
        </div>

        <div class="resume-step-heading-container">
            <h3 class="resume-step-heading">Hobbies and Affiliations</h3>
        </div>
        <div class="resume-step-form">
            <div class="grid-x grid-margin-x">
                <div class="cell medium-10">
                    <div class="form-group">
                        <label>Hobby or Affiliation <span class="label-optional-text">Press enter to add</span></label>
                        <input type="text" v-model="hobbyString" placeholder="Enter a hobby or affiliation" @keyup.enter="addHobby()" />
                    </div>
                </div>
                <div class="cell medium-2">
                    <el-button type="primary" style="margin-top: 25px;" circle @click="addHobby()">⏎</el-button>
                </div>

                <div class="cell">
                    <draggable v-model="hobbies" group="hobbies" @start="drag=true" @end="drag=false" class='grid-x grid-margin-x'>
                        <div class="cell grabbable" v-for="hobby in hobbies" :key="hobby.id">
                            <div class="card" style="padding: 12px!important;">
                                <div class="card-section">
                                    <p class="float-left" style="margin-bottom: 0;">
                                        <i class="el-icon-s-grid" style="color: lightgrey;"></i> {{ hobby.name }}
                                    </p>
                                    <el-button class="float-right" type="danger" icon="el-icon-delete" circle @click="removeHobby(hobby.id)"></el-button>
                                </div>
                            </div>
                        </div>
                    </draggable>
                </div>

            </div>
        </div>

        <div class="resume-form-nav-buttons">
            <button class="button back-button" @click="$router.go(-1)"><font-awesome-icon aria-hidden="true"  class="fancy-select-icon" :icon="['fas', 'arrow-left']"></font-awesome-icon></button>
            <button class="button preview-button">Preview</button>
            <router-link tag="button" class="button" to="customize-design">Save and Next</router-link>
        </div>
    </div>
</template>
<script>
    import draggable from 'vuedraggable';
    export default {
        components: {draggable},
        computed: {
            skills: {
                get() {
                    return this.$store.state.resume.resume_skill;
                },
                async set(value) {
                    await this.$store.dispatch('updateResumeSkillsOrder', value);
                }
            },
            hobbies: {
                get() {
                    return this.$store.state.resume.hobbies;
                },
                async set(value) {
                    await this.$store.dispatch('updateResumeHobbiesOrder', value);
                }
            },
            refreshPreview: {
                get() {
                    return this.$store.state.refreshPreview;
                }
            }
        },
        data: function () {
            return {
                skillString: ''
            }
        },
        methods: {
            addSkill: async function () {
                await this.$store.dispatch('axiosPostRequest', {
                    route: '/skill',
                    payload: {
                        resume_id: this.$store.state.resume.id,
                        name: this.skillString,
                        order: this.skills.length + 1,
                    },
                    commits: ['reloadResume'],
                    successMessage: 'Successfully added skill',
                });

                this.skillString = '';
                this.updateRefreshPreview()
            },
            removeSkill: function (skillId) {
                this.$store.dispatch('axiosDeleteRequest', {
                    route: '/skill/' + skillId,
                    commits: ['reloadResume'],
                    successMessage: 'Successfully removed skill',
                })
                this.updateRefreshPreview()
            },
            updateRefreshPreview: function (event) {
                this.$store.commit('updateRefreshPreview')
            },
            addHobby: async function () {
                await this.$store.dispatch('axiosPostRequest', {
                    route: '/hobby',
                    payload: {
                        resume_id: this.$store.state.resume.id,
                        name: this.hobbyString,
                        order: this.hobbies.length + 1,
                    },
                    commits: ['reloadResume'],
                    successMessage: 'Successfully added item',
                });

                this.hobbyString = '';
                await this.updateRefreshPreview()
            },
            removeHobby: async function (hobbyId) {
                this.$store.dispatch('axiosDeleteRequest', {
                    route: '/hobby/' + hobbyId,
                    commits: ['reloadResume'],
                    successMessage: 'Successfully removed item',
                })
                await this.updateRefreshPreview()
            },
        }
    }
</script>
<style scoped>
    .grabbable {
        cursor: grab;
    }
</style>
