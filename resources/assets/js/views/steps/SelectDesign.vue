<template>
    <div>
        <div class="resume-step-heading-container">
            <h3 class="resume-step-heading">Select Design</h3>
        </div>

        <div class="grid-x grid-margin-x">
            <div class="cell small-6 medium-4 large-6" v-for="design in resumeDesigns"  v-bind:key="design.name">
                <div class="card" v-if="design.active">
                    <h3 class="card-heading">{{ design.name }}</h3>
                    <div class="card-image">
                        <img width="85" height="85" src="https://via.placeholder.com/250" alt="">
                    </div>
                    <label class="button text-center" :class="{
                            'button-no-fill' : resume.resume_design_id != design.id
                        }">

                        <input class="hide" type="radio" v-model="resume.resume_design_id" @change="applyDesign(design.name)" :value="design.id">
                        <font-awesome-icon v-if="resume.resume_design_id === design.id" aria-hidden="true"  class="fancy-select-icon" :icon="['fas', 'check-square']"></font-awesome-icon> Use Design
                    </label>
                </div>
            </div>
            <div class="cell">

            </div>
        </div>
        <div class="resume-form-nav-buttons">
            <button class="button back-button" @click="$router.go(-1)"><font-awesome-icon aria-hidden="true"  class="fancy-select-icon" :icon="['fas', 'arrow-left']"></font-awesome-icon></button>
            <button class="button preview-button" @click="updateToggleResumePreview"><span v-if="toggleResumePreview">Stop </span>Preview</button>
            <button @click="onSave" to="contact-information" tag="button" class="button">Save and Continue</button>
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
                'toggleResumePreview',
            ]),
        },

        mounted() {
        },

        methods: {
            async onSave(){
                const success = await this.$store.dispatch('axiosPutRequest', {
                    route: '/resume/' + this.resume.id,
                    payload: this.resume,
                    successMessage: 'Successfully changed resume design',
                });
                
                if(success)
                    this.$router.push({ name: 'contact-information', query: this.$route.query });
            },
            applyDesign: async function (name) {
                this.$store.commit('updateCurrentResumeDesign', name);
            },
            updateRefreshPreview: function (event) {
                // this.$store.commit('updateRefreshPreview')
            },
            updateToggleResumePreview: function (event) {
                // this.$store.commit('updateToggleResumePreview', !this.toggleResumePreview)
            },
        }
    }
</script>
