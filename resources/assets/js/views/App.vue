<template>
    <div>
        <div class="resume-steps-container">
            <div class="grid-container">
                <div class="grid-x grid-margin-x">
                    <div class="cell">
                        <el-steps :active="activeStep"
                            align-center
                            process-status="finish"
                            finish-status="success"
                            >
                            <el-step v-for="step in steps"
                                :key="step.link"
                                :title="step.title"
                                :icon="step.icon"
                                v-on:click.native="step.link === $route.name ? null : $router.push({name: step.link, query: $route.query})"
                                >
                            </el-step>
                        </el-steps>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid-container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {
        computed: {
            activeStep: function () {
                // this.$route.name
                for(var i = 0; i < this.steps.length; i += 1) {
                    if(this.steps[i]['link'] === this.$route.name) {
                        return i;
                    }
                }
                return -1;
            }
        },
        data: function () {
            return {
                widowWidth : window.outerWidth,
                steps: [
                    {
                        link: 'home',
                        title: 'Home',
                        icon: 'el-icon-house',
                    },
                    {
                        link: 'select-design',
                        title: "Select Design",
                        icon: 'el-icon-picture'
                    },
                    {
                        link: 'contact-information',
                        title: 'Contact Information',
                        icon: 'el-icon-wallet',
                    },
                    {
                        link: 'resume-summary',
                        title: 'Resume Summary',
                        icon: 'el-icon-s-order',
                    },
                    {
                        link: 'work-experience',
                        title: 'Work Experience',
                        icon: 'el-icon-office-building',
                    },
                    {
                        link: 'education',
                        title: 'Education',
                        icon: 'el-icon-collection',
                    },
                    {
                        link: 'skills',
                        title: 'Skills',
                        icon: 'el-icon-star-off',
                    },
                    {
                        link: 'customize-design',
                        title: 'Customize',
                        icon: 'el-icon-setting',
                    },
                    {
                        link: 'full-page-preview',
                        title: 'Preview',
                        icon: 'el-icon-printer',
                    },

                ],
            }
        },
        mounted() {
            this.doResize()
            window.addEventListener('resize', this.doResize)
        },
        methods: {
            doResize: function() {
                this.widowWidt = window.outerWidth

            }
        }
    }
</script>
<style scoped>
    .el-step {
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    }

    @media print {
        body *, .el-steps * {
            visibility: hidden;
        }
    }
</style>

<style>
    /* need this to override _form-elements.scss */
    /* _form-elements was causing the calendar icon to be forced down 1.5rem */
    .el-input__inner {
        margin-bottom: 0!important;
    }
</style>
