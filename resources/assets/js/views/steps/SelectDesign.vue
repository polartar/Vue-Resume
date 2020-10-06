<template>
    <div>
        <h3>Select Design</h3>

        <div class="resume-step-form">
            <div class="grid-x grid-margin-x">
                <div class="cell medium-6">
                    <div class="form-group">
                        <select
                            v-model="resume.resume_design_id"
                            @change="applyDesign"
                            class="fancy-select fancy-select-full-width"
                        >
                            <option disabled selected>-- Pick a Design --</option>
                            <option v-for="design in resumeDesigns" :value="design.id" :key="design.id">
                                {{ design.name }}
                            </option>
                        </select>
                    </div>
                    <button class="button" @click="$router.go(-1)" style="background-color: grey!important;">Back</button>
                    <router-link to="contact-information" tag="button" class="button">Next</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapGetters} from 'vuex'

    export default {
        computed: {
            ...mapState([
                'resume',
                'resumeDesigns',
            ]),
        },

        mounted() {
            console.log(this.resumeDesigns)
        },

        methods: {
            applyDesign: function () {
                this.$axios
                    .put('/resume/' + this.resume.id, this.resume)
                    .then(response => {
                        this.$store.commit('reloadResume');
                        this.$toasted.show('Successfully changed resume design', {
                            position: 'bottom-center',
                            duration: 3000,
                            fullWidth: true,
                            type: 'success',
                        });
                    })
                    .catch(error => {
                        this.$toasted.show('Uh oh, we had an issue with that', {
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
