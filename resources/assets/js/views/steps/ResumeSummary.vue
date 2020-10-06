<template>
    <div>
        <h3>Resume Summary</h3>

        <div class="resume-step-form">
            <div class="grid-x grid-margin-x">
                <div class="cell">
                    <div class="form-group">
                        <label>Summary</label>
                        <textarea v-model="name" required name="summary" rows="8" cols="80" />
                    </div>
                </div>
                <div class="cell medium">
                    <div class="form-group">
                        <button class="button" @click="$router.go(-1)" style="background-color: grey!important;">Back</button>
                        <router-link tag="button" class="button" v-on:click.native="saveSummary" to="work-experience">Save and Next</router-link>
                    </div>
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
            }
        },
        methods: {
            saveSummary: function () {
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
        }
    }
</script>
