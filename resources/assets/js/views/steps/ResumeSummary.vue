<template>
    <div>
        <div class="resume-step-heading-container">
            <h3 class="resume-step-heading">
                Resume Summary
                <small style="text-decoration: underline; cursor: pointer;" @click="show = !show">
                    <span v-if="!show">Add</span><span v-else>Cancel</span>
                </small>
            </h3>
        </div>

        <div class='resume-step-form' v-if="show">
            <div class='grid-x grid-margin-x'>
                <div class='cell'>
                    <div class='form-group'>
                        <label>Summary</label>
                        <textarea rows='8' cols='80' v-model='name' />
                    </div>
                    <div class='form-group'>
                        <label>
                            <input type='checkbox' v-model='bulleted' />
                            Bullet Point?
                        </label>
                        <br/>
                        <em class='text-small'>Each new line will be an item in a list if <strong>Bullet Point</strong> is checked.</em>
                    </div>
                </div>
            </div>
            <button v-if="edit" class='button' type='button' @click='updateSummary'>Update Summary</button>
            <button v-if="edit" class='button' type='button' @click='show = !show'>Cancel</button>
            <button v-else class='button' type='button' @click='saveSummary'>Add Summary</button>
        </div>
        <div>
            <draggable v-model="summaries" group="resume-summaries" @start="drag=true" @end="drag=false" class="grid-x grid-margin-x" :sort="true">
                <div class="cell grabbable" v-for="summary in summaries" :key="summary.id">
                    <div class="card">
                        <div class="card-section">
                            <p class="float-left" style="margin-bottom: 0;">
                                {{ summary.name }}
                            </p>
                            <el-button class="float-right" type="danger" icon="el-icon-delete" circle @click="removeSummary(summary.id)"></el-button>
                            <el-button class="float-right" type="primary" icon="el-icon-edit" circle @click="editSummary(summary.id)"></el-button>
                        </div>
                    </div>
                </div>
            </draggable>
        </div>

        <div class="resume-form-nav-buttons">
            <button class="button back-button" @click="$router.go(-1)"><font-awesome-icon aria-hidden="true"  class="fancy-select-icon" :icon="['fas', 'arrow-left']"></font-awesome-icon></button>
            <button class="button preview-button" @click="updateToggleResumePreview"><span v-if="toggleResumePreview">Stop </span>Preview</button>
            <router-link tag="button" class="button" to="work-experience" @click.native="moveNext">Save &amp; Continue</router-link>
        </div>
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex'
    import draggable from 'vuedraggable'

    export default {
        components: {
            draggable,
        },
        computed: {
            ...mapState([
                'resume',
                'toggleResumePreview',
                'refreshPreview',
            ]),
            'summaries': {
                get() {
                    return this.$store.state.resume.resume_summaries;
                },
                set(value) {
                    this.$store.dispatch('updateResumeSummaryOrder', value);
                }
            }
        },
        data: function () {
            return {
                'name': '',
                'bulleted': true,
                'show': false,
                'edit': false,
                'editId': '',
            }
        },
        methods: {
            saveSummary: async function () {
                this.show = false;

                const success = await this.$store.dispatch('axiosPostRequest', {
                    route: '/resume-summary',
                    payload: {
                        'resume_id': this.$store.state.resume.id,
                        'name': this.name,
                        'bullet_point': this.bulleted,
                    },
                    successMessage: 'Successfully added the resume summary',
                    commits: ['reloadResume'],
                });

                if (success)
                    this.name = '';
                    await this.updateRefreshPreview()
            },
            updateSummary: async function () {
                this.show = false;

                const success = await this.$store.dispatch('axiosPutRequest', {
                    route: '/resume-summary/' + this.editId,
                    payload: {
                        'name': this.name,
                        'bullet_point': this.bulleted,
                    },
                    successMessage: 'Successfully updated the resume summary',
                    commits: ['reloadResume'],
                });

                if (success) {
                    this.name = '';
                    this.edit = false;
                    await this.updateRefreshPreview()
                }
            },
            updateToggleResumePreview: function (event) {
                this.$store.commit('updateToggleResumePreview', !this.toggleResumePreview)
            },
            editSummary: function (summaryId) {
                this.name = this.resume.resume_summaries.find(obj => obj.id === summaryId).name;
                this.bulleted = this.resume.resume_summaries.find(obj => obj.id === summaryId).bullet_point;
                this.edit = true;
                this.editId = summaryId;
                this.show = true;
            },
            removeSummary: async function (summaryId) {
                const success = await this.$store.dispatch('axiosDeleteRequest', {
                    route: '/resume-summary/' + summaryId,
                    payload: {},
                    successMessage: 'Successfully removed the resume summary',
                    commits: ['reloadResume'],
                });
                await this.updateRefreshPreview()
            },
            updateRefreshPreview: function (event) {
                this.$store.commit('updateRefreshPreview')
            },
            moveNext(){
                if(this.show){
                    this.$store.dispatch('axiosPostRequest', {
                        route: '/resume-summary',
                        payload: {
                            'resume_id': this.$store.state.resume.id,
                            'name': this.name,
                            'bullet_point': this.bulleted,
                        },
                        commits: ['reloadResume'],
                    }).then(res=>this.updateRefreshPreview())
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
