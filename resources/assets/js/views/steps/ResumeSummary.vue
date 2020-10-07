<template>
    <div>
        <h3>
            Resume Summary
            <small style="text-decoration: underline; cursor: pointer;" @click="show = !show">
                <span v-if="!show">Create</span><span v-else>See All Summaries</span>
            </small>
        </h3>

        <div class='resume-step-form' v-if="show">
            <div class='grid-x grid-margin-x'>
                <div class='cell'>
                    <div class='form-group'>
                        <label>Summary</label>
                        <textarea rows='8' cols='80' v-model='name' />
                    </div>
                </div>
            </div>
            <button class='button' type='button' @click='saveSummary'>Add Summary</button>
        </div>
        <div class='resume-step-form' v-if="!show">
            <div class='grid-x grid-margin-x'>
                <div class="cell" v-for="summary in resume.resume_summaries" :key="summary.id">
                    <div class="card">
                        <div class="card-section">
                            <p class="float-left" style="margin-bottom: 0;">
                                {{ summary.name }}
                            </p>
                            <button class="button close-button float-right" @click="removeSummary(summary.id)">X</button>
                        </div>
                    </div>
                </div>
                <div class="cell">
                    <button class="button" @click="$router.go(-1)" style="background-color: grey!important;">Back</button>
                    <router-link tag="button" class="button" to="work-experience">Next</router-link>
                </div>
            </div>
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
                        this.$toasted.show('Successfully updated the resume summary', {
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
