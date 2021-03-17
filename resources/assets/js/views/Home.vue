<template>
    <div class="grid-x grid-margin-x align-center">
        <div class="cell large-5" v-if="this.$route.name !== 'full-page-preview'">
            <div class="form-group" v-if="this.$route.name === 'home'">
                <h3>Home</h3>
                <label>Resume Name</label>
                <input :value="resumeName" type="text" @change="updateResumeName">

            </div>
            <div class="resume-form-nav-buttons" v-if="this.$route.name === 'home'">
                <button class="button preview-button" @click="updateToggleResumePreview"><span v-if="toggleResumePreview">Stop </span>Preview</button>
                <button class="button" @click="saveResumeName" to="select-design">Save &amp; Continue</button>
            </div>
            <router-view></router-view>
        </div>
        <div class="" style="width:848px" v-if="this.$route.name === 'full-page-preview'">
            <div class="full-preview">
                <router-view></router-view>
            </div>
        </div>
        <div class="cell medium-7 large-6 large-offset-1 resume-preview-cell"
            :class="{
                'hide-for-small-only': !toggleResumePreview,
                'hide-for-medium-only': !toggleResumePreview,
                'full-page-resume-preview': toggleResumePreview
            }"
             v-if="this.$route.name !== 'full-page-preview'">
            <h4 class="m-t-n">Preview of {{ resumeName }}</h4>
            <div class="resume-preview-container">
                <full-page-preview></full-page-preview>
            </div>
        </div>
    </div>
</template>


<script>
    import {mapState, mapGetters} from 'vuex'
    import FullPagePreview from "./steps/FullPagePreview";

    export default {
        components: {FullPagePreview},
        computed: {
            ...mapState([
                'resume',
                'toggleResumePreview',
            ]),
            ...mapGetters([
                'resumeName',
                'resumeSummary',
            ])
        },

        mounted() {
            this.fetchResume();
            this.fetchResumeDesigns();
        },

        methods: {
            fetchResume: function () {
                const resumeId = this.$route.query.resume;
                this.$axios
                    .get('/resume/' + resumeId)
                    .then(response => {
                        let resume = response.data.resume;

                        this.$store.commit('updateResume', resume);
                        this.$store.commit('updateFirstName', resume.user.first_name);
                        this.$store.commit('updateLastName', resume.user.last_name);
                        this.$store.commit('updateUserEmailIds', resume.user_email_ids);
                        this.$store.commit('updateUserEmail', resume.user.email);
                        this.$store.commit('updateUserAddressIds', resume.user_address_ids);
                        this.$store.commit('updateUserPhoneIds', resume.user.user_phones);

                        if (resume.resume_summaries.length > 0) {
                            this.$store.commit('updateSummary', resume.resume_summaries[0]);
                        }

                        let links = response.data.resume.resume_links
                        let linkedin_url = links.find(o => o.name === "LinkedIn");
                        
                        if(linkedin_url)
                            this.$store.commit('updateLinkedInUrl', linkedin_url.url);

                        if (resume.user_phone_id) {
                            this.getPhoneNumber(resume.user_phone_id);
                        }
                        
                        if (resume.user_email_id) {
                            this.getUserEmail(resume.user_email_id);
                        }
                        
                        if (resume.user_address_id) {
                            this.getUserAddress(resume.user_address_id);
                        }

                    })
                    .catch(error => {
                        console.log('failed to retrieve resume', error)
                    });
            },
            fetchResumeDesigns: function () {
                this.$axios.get('/resume-design')
                    .then(response => {
                        this.$store.commit('updateResumeDesigns', response.data.resumeDesigns);
                    })
            },
            getPhoneNumber: function (phoneId) {
                this.$axios
                    .get('/user-phone/' + phoneId)
                    .then(response => {
                        this.$store.commit('updatePhone', response.data.userPhone.phone_number);
                    })
                    .catch(error => {
                        console.log('failed to retrieve phone number');
                    });
            },
            getUserAddress: function (userAddressId) {
                this.$axios
                    .get('/user-address/' + userAddressId)
                    .then(response => {
                        this.$store.commit('updateAddress', response.data.userAddress);
                    })
                    .catch(error => {
                        console.log('failed to retrieve phone number');
                    });
            },
            getUserEmail: function (userEmailId) {
                this.$axios
                    .get('/user-email/' + userEmailId)
                    .then(response => {
                        this.$store.commit('updateResumeEmail', response.data.userEmail.email);
                    })
                    .catch(error => {
                        console.log('failed to retrieve phone number');
                    });
            },
            updateResumeName: function (event) {
                this.$store.commit('updateResumeName', event.target.value);
            },
            updateToggleResumePreview: function (event) {
                this.$store.commit('updateToggleResumePreview', !this.toggleResumePreview)
            },
            updateRefreshPreview: function (event) {
                this.$store.commit('updateRefreshPreview')
            },
            saveResumeName: async function () {
                const success = await this.$store.dispatch('axiosPutRequest', {
                    route: '/resume/' + this.resume.id,
                    payload: this.resume,
                    successMessage: 'Successfully updated the resume name',
                });

                if (success)
                    this.$router.push({name: 'select-design', query: this.$route.query});
                    await this.updateRefreshPreview()
            }
        }
    }
</script>
<style>
    .el-notification__content p {
        text-align: left!important;
    }

    .el-notification__content, .el-notification__title {
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    }
</style>
