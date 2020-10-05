<template>
    <div>

        <p style="text-align: center;">
            <router-link v-for="step in steps"
                         :key="step.link"
                         :to="{ name: step.link }"
                         style="margin-right: 10px;"
            >{{ step.title }}</router-link>
        </p>

        <div class="grid-container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                steps: [
                    {
                        link: 'home',
                        title: 'Home',
                    },
                    {
                        link: 'select-design',
                        title: "Select Design",
                    },
                    {
                        link: 'contact-information',
                        title: 'Contact Information',
                    },
                    {
                        link: 'resume-summary',
                        title: 'Resume Summary',
                    },
                    {
                        link: 'work-experience',
                        title: 'Work Experience'
                    },
                    {
                        link: 'education',
                        title: 'Education'
                    },
                    {
                        link: 'skills',
                        title: 'Skills',
                    },
                    {
                        link: 'customize-design',
                        title: 'Customize'
                    },
                    {
                        link: 'full-page-preview',
                        title: 'Preview'
                    },

                ],
            }
        }
    }
</script>
