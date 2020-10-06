<template>
    <div>
        <el-steps :active="activeStep" 
            align-center 
            style="padding-top: 10px; cursor: pointer;"
            process-status="finish"
            finish-status="success"
            >
            <el-step v-for="step in steps"
                :key="step.link"
                :title="step.title" 
                :icon="step.icon"
                v-on:click.native="$router.push({name: step.link})"
                >
            </el-step>
        </el-steps>

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
        }
    }
</script>
