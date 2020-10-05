<template>
    <div v-if="resume.resume_design" class="resume-container">
        <golden-standard v-if="resume.resume_design.name === 'Golden Standard'"></golden-standard>
        <functional v-if="resume.resume_design.name === 'Functional'"></functional>
        <combination v-if="resume.resume_design.name === 'Combination'"></combination>
        <recruiter v-if="resume.resume_design.name === 'Recruiter'"></recruiter>
        <sidebar v-if="resume.resume_design.name === 'Sidebar'"></sidebar>
    </div>
</template>

<script>
    import {mapState, mapGetters} from 'vuex'
    import GoldenStandard from "../resume-templates/GoldenStandard";
    import Functional from "../resume-templates/Functional";
    import Combination from "../resume-templates/Combination";
    import Recruiter from "../resume-templates/Recruiter";
    import Sidebar from "../resume-templates/Sidebar";

    export default {
        components: {Recruiter, Functional, GoldenStandard, Combination, Sidebar},
        computed: {
            ...mapState([
                'resume',
            ]),
            ...mapGetters([
                'resumeName',
                'resumeSummary',
            ])
        },

        mounted() {},

        methods: {}
    }
</script>

<style>
    div.resume-container {
        background-color: ghostwhite;
        width: 100%;
        min-height: 100vh;
        display: flex;
        flex-flow: row;
        justify-content: space-around;
        padding-top: 15px;
    }
</style>

