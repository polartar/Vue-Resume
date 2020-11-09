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
            },
            removeSkill: function (skillId) {
                this.$store.dispatch('axiosDeleteRequest', {
                    route: '/skill/' + skillId,
                    commits: ['reloadResume'],
                    successMessage: 'Successfully removed skill',
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
