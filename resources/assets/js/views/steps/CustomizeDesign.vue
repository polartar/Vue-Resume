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

        <div class="resume-form-nav-buttons">
            <button class="button back-button" @click="$router.go(-1)"><font-awesome-icon aria-hidden="true"  class="fancy-select-icon" :icon="['fas', 'arrow-left']"></font-awesome-icon></button>
            <button class="button preview-button">Preview</button>
            <router-link tag="button" class="button" to="full-page-preview">Save &amp; Continue</router-link>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            dateFormat: {
                get() {
                    return this.$store.state.resume.date_format;
                },
                set(value) {
                    this.$store.dispatch('updateResumeDateFormat', value);
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
            }
        }
    }
</script>
