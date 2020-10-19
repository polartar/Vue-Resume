<template>
    <div>
        <div class="resume-step-heading-container">
            <h3 class="resume-step-heading">
                Resume Summary
                <small style="text-decoration: underline; cursor: pointer;" @click="show = !show">
                    <span v-if="!show">Create</span><span v-else>Cancel</span>
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
                </div>
            </div>
            <button v-if="edit" class='button' type='button' @click='updateSummary'>Update Summary</button>
            <button v-else class='button' type='button' @click='saveSummary'>Add Summary</button>
        </div>
        <div v-if="!show">
            <div class='grid-x grid-margin-x'>
                <div class="cell" v-for="summary in resume.resume_summaries" :key="summary.id">
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
            </div>
        </div>

        <div class="resume-form-nav-buttons">
            <button class="button secondary-button" @click="$router.go(-1)">Back</button>
            <router-link tag="button" class="button" to="work-experience">Save &amp; Continue</router-link>
        </div>
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex'

    export default {

        computed: mapState([
            'resume',
        ]),
        data: function () {
            return {
                'name': '',
                'show': false,
                'edit': false,
                'editId': '',
            }
        },
        methods: {
            saveSummary: function () {
                this.show = false;
                this.$axios
                    .post('/resume-summary', {
                        'resume_id': this.$store.state.resume.id,
                        'name': this.name,
                    })
                    .then(response => {
                        this.$toasted.show('Successfully added the resume summary', {
                            position: 'bottom-center',
                            duration: 3000,
                            fullWidth: true,
                            type: 'success',
                        });
                        this.$store.commit('reloadResume');
                        this.name = '';
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
            updateSummary: function () {
                this.show = false;
                this.$axios
                    .put('/resume-summary/' + this.editId, {
                        'name': this.name,
                    })
                    .then(response => {
                        this.$toasted.show('Successfully updated the resume summary', {
                            position: 'bottom-center',
                            duration: 3000,
                            fullWidth: true,
                            type: 'success',
                        });
                        this.$store.commit('reloadResume');
                        this.name = '';
                        this.edit = false;
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
            editSummary: function (summaryId) {
                console.log(this.resume.resume_summaries.find(obj => obj.id === summaryId));
                this.name = this.resume.resume_summaries.find(obj => obj.id === summaryId).name;
                this.edit = true;
                this.editId = summaryId;
                this.show = true;
            },
            removeSummary: function (summaryId) {
                this.$axios
                    .delete('/resume-summary/' + summaryId)
                    .then(response => {
                        this.$toasted.show('Successfully updated the resume summary', {
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
            }
        }
    }
</script>
<style scoped>
    .el-button {
        margin-right: 10px;
    }
</style>
