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
                            ref='elSteps'
                            >
                            <el-step v-for="step in steps"
                                :key="step.link"
                                :title="step.title"
                                :icon="step.icon"
                                :status="getStatus(step.link)"
                                v-on:click.native="e=>nextStep(step)"
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
import { mapState } from 'vuex';
import {defaultsteps, combinationsteps, sidebarsteps} from "../constants/steps"
    export default {
        computed: {
            activeStep: function () {
                for(var i = 0; i < this.steps.length; i += 1) {
                    if(this.steps[i]['link'] === this.$route.name) {
                        return i;
                    }
                }
                return -1;
            },
            ...mapState([
            'resume',
            'firstName',
            ]),            
        },
        watch:{
            resume(value){
                const resume_type = value.resume_design.name;
                if(resume_type ==='Functional' || resume_type ==='Recruiter')
                {
                    this.steps = combinationsteps;
                    if(resume_type ==='Recruiter'){
                        this.steps = this.steps.map(step=>{
                            if(step.link === "work-experience"){
                                return {...step, title: 'Work Experience'};
                            }
                            if(step.link === "skills"){
                                return {...step, title: 'Techniques, Software & Instrumentation'};
                            }
                            return step;
                        })
                    }
                } else if (resume_type ==='Sidebar'){
                    this.steps = sidebarsteps;
                }
                else {
                    this.steps = defaultsteps;
                }
            }
        },
        data: function () {
            return {
                widowWidth : window.outerWidth,
                steps:defaultsteps  
            }
        },
        mounted() {
            this.doResize()
            window.addEventListener('resize', this.doResize)
        },
        methods: {
            getStatus(link){
                if(link === this.$route.name)
                    return "finish";
  
                // const arr = Object.keys(this.resume);
                if(!this.resume.email) return;

                const resume = {...this.resume, firstName:this.firstName?[this.firstName]:[]};
                //validate the steps
                const step_links = ['home', 'select-design','contact-information','resume-summary', 'work-experience', 'education', 'skills', 'hobbies', 'customize-design', 'full-page-preview']
                const resume_fields=['name', 'resume_design_id', 'firstName', 'resume_summaries', 'resume_work_experiences', 'resume_educations', 'resume_skill', 'hobbies', 'hobbies', 'hobbies']
          
                const index = step_links.indexOf(link);
             

                if(resume[resume_fields[index]].length ===0)
                    return "process";
                else    
                    return "success"
            },
            doResize: function() {
                this.widowWidt = window.outerWidth
            },
            nextStep(step){                
                step.link === this.$route.name ? null : this.$router.push({name: step.link, query: this.$route.query})
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
