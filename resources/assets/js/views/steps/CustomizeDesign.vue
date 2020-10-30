<template>
    <div>
        <div class="resume-step-heading-container">
            <h3 class="resume-step-heading">Customize Design</h3>
        </div>

        <div class="resume-step-form">
            <div class="grid-x grid-margin-x">
                <div class="cell medium-6">
                    <div class="form-group">
                        <label>Date Format</label>
                        <select class="fancy-select fancy-select-full-width" v-model="dateFormat">
                            <option v-for="format in dateFormats" :value="format.id" :key="format.id">{{format.value}}</option>
                        </select>
                    </div>
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
                            <div class="card">
                                <div class="card-section">
                                    <p class="float-left" style="margin-bottom: 0;">
                                        {{ hobby.name }}
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
            <router-link tag="button" class="button" to="full-page-preview">Save &amp; Continue</router-link>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable';

    export default {
        components: {draggable},
        computed: {
            dateFormat: {
                get() {
                    return this.$store.state.resume.date_format;
                },
                set(value) {
                    this.$store.dispatch('updateResumeDateFormat', value);
                }
            },
            hobbies: {
                get() {
                    return this.$store.state.resume.hobbies;
                },
                async set(value) {
                    await this.$store.dispatch('updateResumeHobbiesOrder', value);
                }
            }
        },
        data: function () {
            return {
                dateSeparater: '',
                dateFormats: [
                    { id: 1, value: 'Year.Month.Day' },
                    { id: 2, value: 'Day.Month.Year' },
                    { id: 3, value: 'Month.Day.Year' },
                    { id: 4, value: 'Year/Month/Day' },
                    { id: 5, value: 'Day/Month/Year' },
                    { id: 6, value: 'Month/Day/Year' },
                    { id: 7, value: 'Year-Month-Day' },
                    { id: 8, value: 'Day-Month-Year' },
                    { id: 9, value: 'Month-Day-Year' },
                ],
                hobbyString: '',
            }
        },
        methods: {
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
            },
            removeHobby: async function (hobbyId) {
                this.$store.dispatch('axiosDeleteRequest', {
                    route: '/hobby/' + hobbyId,
                    commits: ['reloadResume'],
                    successMessage: 'Successfully removed item',
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