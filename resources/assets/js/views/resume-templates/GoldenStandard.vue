<template>
    <div class='print-paper resume-gold-standard resume-html-page' ref='resume_body'>
        <table class="full-width-table" align="center" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td class="text-left">
                        <p class="resume-title">{{ fullName }}</p>
                    </td>
                    <td class="text-right">
                        <table class="full-width-table header-contact-info" align="center" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td class="contact-info">
                                        {{ street_1 }} {{street_2 }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="contact-info">
                                        {{ city }}, {{ province }} {{ zip }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="contact-info">
                                        {{ phone}}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="contact-info">
                                        {{ resume.email}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="contact-info">
                                        {{this.resume.linkedin_url}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="full-width-table resume-section " ref='summary' v-if="resume && resume.resume_summaries[0]" align="center" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td><span class="section-heading " >Summary</span></td>
                </tr>
                <tr>
                    <td class="section-summary">
                        <ul :class="this.resume.resume_summaries[0].bullet_point?'':'bulletless-list'">
                            <li class="summary-list-item" v-for="(summary) in resume.resume_summaries" :key="summary.id" >
                                <p>{{summary.name}}</p>
                            </li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="full-width-table resume-section" align="center" cellpadding="0" cellspacing="0" >
            <tbody>
                <tr>
                    <td><span class="section-heading " ref='work_title'>Work Experience</span></td>
                </tr>
                <tr v-for="work in resume && resume.resume_work_experiences" class="section" :key="work.id" ref="work_child">
                    <td class="section-group">
                    
                        <table class="full-width-table" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td><span class="section-sub-title">{{ work.position_title }}</span></td>
                                <td class="text-right"><span class="section-dates">{{ work.position_start_date}} to {{ work.position_end_date ? work.position_end_date : 'present' }}</span></td>
                            </tr>
                            <tr>
                                <td colspan="2"><span class="section-sub-sub-title">{{ work.position_company }}</span></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="work-experience-description" v-for="(description, index) in work.resume_descriptions" :key="index">
                                    <ul >
                                        <li class="" v-for="(item, index) in stringToArray(description.description)" :key="index" >
                                            {{item}}
                                        </li>
                                    </ul>
                                    <!-- <p v-for="(description, index) in work.resume_descriptions" class="work-experience-description" :key="index">{{description.description}}</p> -->
                                </td>
                            </tr>
                        </table>
                     </td>
                </tr>
    
            </tbody>
        </table>
    
        <table class="full-width-table resume-section"  v-if="resume && resume.resume_educations[0]" align="center" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td><span class="section-heading ">Education</span></td>
                </tr>
                <tr  v-for="education in resume.resume_educations" :key="education.id">
                    <td class="section-group">
                    
                        <table class="full-width-table" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td><span class="section-sub-title">{{ education.degree_received }} in {{ education.field_of_study }}</span></td>
                                <td class="text-right"><span class="section-dates">{{ education.start_date}} to {{ education.end_date ? education.end_date : 'present' }}</span></td>
                            </tr>
                            <tr>
                                <td><span class="section-sub-sub-title">{{ education.school_name }}</span></td>
                                <td class="text-right"></td>
                            </tr>
                            <!-- {{-- <tr>
                                <td colspan="2" class="section-summary" v-if="education.educationDescriptions.length > 0">
                                        <p v-for="(description, id) in education.educationDescriptions" v-bind:key="id">{{ description.description }}</p>
                                </td>
                            </tr> --}} -->
                        </table>
                    </td>
                </tr>
            
            </tbody>
        </table>

        <table class="full-width-table resume-section"   align="center" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td><span class="section-heading">Techniques, Software, & Instrumentation</span></td>
                </tr>
                <tr>
                    <td class="skill-body"  v-if="resume && resume.resume_skill[0]" >
                        <div class="skill-row">
                            <div class='skill-column'  v-for="skill in resume.resume_skill" v-bind:key="skill.id">
                                {{ skill.name }}
                            </div>
                        </div>
                        <!-- <table class="full-width-table" v-if="resume && resume.resume_skill[0]" align="center" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr v-for="skill in resume.resume_skill" v-bind:key="skill.id">
                                    <td>
                                        <ul class="bulletless-list">
                                            <li>{{ skill.name }}</li>
                                        </ul>
                                        </td>
                                    </tr>
                            </tbody>
                        </table> -->
                    </td>
                </tr>
            </tbody>
        </table>

        
        <table class="full-width-table resume-section" align="center" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td><span class="section-heading">Affiliations &amp; Hobbies</span></td>
                </tr>
                <tr>
                    <td class="section-summary">
                        <table class="full-width-table" align="center" cellpadding="0" cellspacing="0" v-if="resume.hobbies[0]">
                            <tbody>
                                <tr>
                                    <td>
                                        <ul class="">
                                            <li v-for="hobby in resume.hobbies" v-bind:key="hobby.id"><p>{{ hobby.name }}</p></li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>  
    </div>

</template>

<script>
    import {mapState, mapGetters} from 'vuex'

    export default {
        computed: {
            ...mapState([
                'phone',
                'street_1',
                'street_2',
                'city',
                'province',
                'zip',
                'country',
                'resume',
            ]),
            ...mapGetters([
                 'fullName',
            ]),

           
        },

        mounted() {
          },
        updated(){
            this.$nextTick(function () {
                // Code that will run only after the
                // entire view has been re-rendered
                //  maring 40px
                const start = this.$refs.resume_body.getBoundingClientRect().top;
                const page_bottom = 1056;
                const offset =  start - 75;

                const work_top = this.$refs.work_title.getBoundingClientRect().top
                const work_childs = this.$refs.work_child;
                if(work_top  < page_bottom + offset){
                    let work_first_end = 0;
                    if(Array.isArray(work_childs)){
                        work_first_end = work_childs[0].getBoundingClientRect().bottom;
                    }else{
                        work_first_end = work_childs.getBoundingClientRect().bottom;
                    }

                    if (work_first_end > page_bottom + offset){
                        // const margin_top = page_bottom - work_top + start - 15;
                        // let div = document.createElement("div");
                        // div.classList.add("html2pdf__page-break")
                        // div.setAttribute("style" ,`margin-top: ${margin_top}px`);
                        // this.insertAfter(div, this.$refs.summary);
                        // this.$refs.work_title.classList.value = this.$refs.work_title.classList + " page-top";
                        this.insertBreak(page_bottom, start, work_top, this.$refs.summary, this.$refs.work_title, "div");
                    }
                }
              
                if(Array.isArray(work_childs)){
                    work_childs.map( ( element, index ) => {
                        if( index !== 0 ){
                            const top = element.getBoundingClientRect().top;
                            const bottom = element.getBoundingClientRect().bottom;
                            if ( ( top < page_bottom + start) && (bottom > page_bottom + offset) )
                            {
                                this.insertBreak(page_bottom, start, top, work_childs[index - 1], element, "td" );
                            }
                            else if ( ( top < page_bottom * 2 + start ) && (bottom > page_bottom * 2 + offset ) ){
                                this.insertBreak(page_bottom * 2, start, top, work_childs[index - 1], element, "td" );
                            }
                        }
                        return element;
                    })
                }
            })
        },
        methods: {
            stringToArray: function (str) {
                if (str.length > 0)
                    return str.split(/\r?\n/)
                return [];
            },

            insertAfter(newNode, existingNode) {
                existingNode.parentNode.insertBefore(newNode, existingNode.nextSibling);
            },

            insertBreak(page_bottom, page_start, current_top , currentNode, nextNode, nodeType){
                const margin_top = page_bottom - current_top + page_start - 15;
                let newNode = document.createElement(nodeType);
                newNode.classList.add("html2pdf__page-break")
                newNode.setAttribute("style" ,`margin-top: ${margin_top}px`);
                this.insertAfter(newNode, currentNode);
                nextNode.classList.add("page-top");
            }

        }
    }
</script>
<style scoped>

</style>