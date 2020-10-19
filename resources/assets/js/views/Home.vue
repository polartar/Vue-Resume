<template>
    <div class="grid-x grid-margin-x">
        <div class="cell medium-6" v-if="this.$route.name !== 'full-page-preview'">
            <div class="form-group" v-if="this.$route.name === 'home'">
                <h3>Home</h3>
                <label>Resume Name</label>
                <input :placeholder="resumeName" type="text" @change="updateResumeName">
                <button class="button" @click="saveResumeName" to="select-design">Save and Next</button>
            </div>
            <router-view></router-view>
        </div>
        <div class="cell" v-if="this.$route.name === 'full-page-preview'">
            <router-view></router-view>
        </div>
        <div class="cell medium-6 resume-preview-cell"
             v-if="this.$route.name !== 'full-page-preview'">
            <h4>Preview of {{ resumeName }}</h4>
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
                'firstName',
                'lastName',
                'email',
                'phone',
                'street_1',
                'street_2',
                'city',
                'province',
                'zip',
                'country',
                'summary',
                'resume',
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
                        console.log(response.data.resume);
                        // Assign name values from resume
                        let resume = response.data.resume;
                        this.$store.commit('updateResume', resume);
                        this.$store.commit('updateFirstName', resume.user.first_name);
                        this.$store.commit('updateLastName', resume.user.last_name);
                        this.$store.commit('updateUserEmail', resume.user.email);
                        this.$store.commit('updateUserEmailIds', resume.user_email_ids);
                        this.$store.commit('updateUserAddressIds', resume.user_address_ids);
                        this.$store.commit('updateUserPhoneIds', resume.user_phone_ids);
                        if (resume.resume_summaries.length > 0) {
                            this.$store.commit('updateSummary', resume.resume_summaries[0]);
                            console.log(this.$store.state.summary);
                        }
                        // From here, we need to bring in:
                        // phone number
                        if (this.$store.state.userPhoneIds.length > 0) {
                            this.getPhoneNumber(this.$store.state.userPhoneIds[0]);
                        }
                        // email TODO: sortable emails, handle later
                        // Address
                        if (this.$store.state.userAddressIds.length > 0) {
                            this.getUserAddress(this.$store.state.userAddressIds[0]);
                        }
                    })
                    .catch(error => {
                        console.log('failed to retrieve resume', error)
                    });
            },
            fetchResumeDesigns: function () {
                this.$axios.get('/resume-design')
                    .then(response => {
                        console.log(response);
                        this.$store.commit('updateResumeDesigns', response.data.resumeDesigns);
                    })
            },
            getPhoneNumber: function (phoneId) {
                this.$axios
                    .get('/user-phone/' + phoneId)
                    .then(response => {
                        console.log(response.data);
                        this.$store.commit('updatePhone', response.data.userPhone.phone_number);
                    })
                    .catch(error => {
                        console.log('failed to retrieve phone number');
                    });
            }
            ,
            getUserAddress: function (userAddressId) {
                this.$axios
                    .get('/user-address/' + userAddressId)
                    .then(response => {
                        console.log(response.data);
                        this.$store.commit('updateAddress', response.data.userAddress);
                    })
                    .catch(error => {
                        console.log('failed to retrieve phone number');
                    });
            },
            updateResumeName: function (event) {
                this.$store.commit('updateResumeName', event.target.value);
            },
            saveResumeName: function () {
                console.log(this.resume);
                this.$axios
                    .put('/resume/' + this.resume.id, this.resume)
                    .then(response => {
                        this.$toasted.show('Successfully updated the resume name', {
                            position: 'bottom-center',
                            duration: 3000,
                            fullWidth: true,
                            type: 'success',
                        });
                        this.$router.push({name: 'select-design', query: this.$route.query});
                    }).catch(response => {
                        this.$toasted.show('Uh oh, we had some trouble with that.', {
                            position: 'bottom-center',
                            duration: 3000,
                            fullWidth: true,
                            type: 'error',
                        });
                        console.log(response);
                });
            }
        }
    }
</script>
