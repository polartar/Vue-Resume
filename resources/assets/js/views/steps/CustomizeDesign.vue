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
                        <div class="fancy-select fancy-select-full-width">
                            <font-awesome-icon aria-hidden="true"  class="fancy-select-icon" :icon="['fas', 'caret-down']"></font-awesome-icon>
                            <select v-model="dateFormat">
                                <option v-for="format in dateFormats" :value="format.id" :key="format.id">{{ format.value }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="resume-form-nav-buttons">
            <button class="button back-button" @click="$router.go(-1)"><font-awesome-icon aria-hidden="true"  class="fancy-select-icon" :icon="['fas', 'arrow-left']"></font-awesome-icon></button>
            <button class="button preview-button" @click="updateToggleResumePreview"><span v-if="toggleResumePreview">Stop </span>Preview</button>
            <router-link tag="button" class="button" to="full-page-preview">Save &amp; Continue</router-link>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable';
    import { mapState } from 'vuex'

    export default {
        components: {draggable},
        computed: {
            dateFormat: {
                get() {
                    return this.$store.state.resume.date_format;
                },
                async set(value) {
                    await this.$store.dispatch('updateResumeDateFormat', value);
                }
            },
            refreshPreview: {
                get() {
                    return this.$store.state.refreshPreview;
                }
            },
            ...mapState([
                'toggleResumePreview',
            ]),
        },
        data: function () {
            return {
                dateSeparater: '',
                dateFormats: [
                    { id: 1, value: this.$moment().format('MMMM YYYY')},
                    { id: 2, value: this.$moment().format('D/M/YYYY')},
                    { id: 3, value: this.$moment().format('D-M-YYYY')},
                    { id: 4, value: this.$moment().format('M/D/YYYY')},
                    { id: 5, value: this.$moment().format('M-D-YYYY')},
                    { id: 6, value: this.$moment().format('M/YYYY')},
                    { id: 7, value: this.$moment().format('M-YYYY')},
                ],
            }
        },
        methods: {

            updateRefreshPreview: function (event) {
                this.$store.commit('updateRefreshPreview')
            },
            updateToggleResumePreview: function (event) {
                this.$store.commit('updateToggleResumePreview', !this.toggleResumePreview)
            },
        }
    }
</script>
<style scoped>
    .grabbable {
        cursor: grab;
    }
</style>
