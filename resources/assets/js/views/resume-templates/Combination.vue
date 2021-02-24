<template>
    <div class='print-paper resume-gold-standard resume-html-page combination' ref='resume_body'>
        <div class="text-left">
            <p class="resume-title">{{ fullName }}</p>
        </div>
        <div class="text-right">
            <table class="full-width-table header-contact-info" align="center" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td class="contact-info">
                            {{ street_1 }} {{street_2 }}
                        </td>
                    </tr>

                    <tr>
                        <td class="contact-info">
                            {{ city }} {{city ? "," : ""}} {{ province }} {{ zip }}
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
        </div>
 

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

        <div class="full-width-table resume-section" ref='skill'   >
               <div class="section-heading" >Key Industry Skills</div>
               <div class="skill-body">
                    <div class="skill-row">
                        <!-- <ul class='' > -->
                           <div ref='skill_child'  v-for="skill in resume.resume_skill" v-bind:key="skill.id"> <li> {{ skill.name }}</li> </div>
                        <!-- </ul> -->
                    </div>
                 </div>
        </div>

        <div class="full-width-table resume-section" ref='work'  >
       
                <div>
                    <span class="section-heading " ref='work_title'>Relevant Work Experience</span> 
                </div>
                <div v-for="work in resume && resume.resume_work_experiences" class="section" :key="work.id" ref="work_child">
                     
                    <table class="full-width-table section-group" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td><span class="section-sub-title">{{ work.position_title }}</span></td>
                            <td class="text-right"><span class="section-dates">{{ dateFormat(work.position_start_date)}} to {{ work.position_end_date ? dateFormat(work.position_end_date) : 'present' }}</span></td>
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
                 </div>
    
           
        </div>
    
        <div class="full-width-table resume-section" ref='education' v-if="resume && resume.resume_educations[0]" >
          
                <div>
                    <td><span class="section-heading " ref='education_title'>Education</span></td>
                </div>
                <div  v-for="education in resume.resume_educations" :key="education.id" ref='education_child'>
                    <table class="full-width-table section-group " align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td><span class="section-sub-title">{{ education.degree_received }} in {{ education.field_of_study }}</span></td>
                            <td class="text-right"><span class="section-dates">{{ dateFormat(education.start_date) }} to {{ education.end_date ? dateFormat( education.end_date) : 'present' }}</span></td>
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
                 </div>
            
        </div>
       
        <div class="full-width-table " ref='hobby'  >
                <div><span class="section-heading">Affiliations &amp; Hobbies</span></div>
                <div>
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
                </div>
        </div>  
    </div>
</template>

<script>
    import {mapState, mapGetters} from 'vuex'
    import {convertDate} from "../../services/utility.js"

    export default {
        data(){
            return {
                pageBottom: 0,
                padding:0,
            }
        },
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
        created(){
           
            window.addEventListener("resize", this.onResize);
        },
        mounted(){
            this.$nextTick(function () {
                this.onResize();
            })
        },
        updated() {
              this.onResize();
        },
        updated(){
            this.$nextTick(function () {
                this.makePageBreak();
            })
        },
        methods: {
            removePageBreak()
            {
                let breaks = document.getElementsByClassName("html2pdf__page-break");
                let len = breaks.length;
                if(breaks && len > 0)
                {
                    for(let i = 0 ; i < len; i++){
                        if(breaks[i])
                          breaks[i].remove();
                    }   
                }

                let headings = document.getElementsByClassName("heading-name");
                len = headings.length;
                if(headings && len > 0)
                {
                    for(let i = 0 ; i < len; i++){
                        if(headings[i])
                            headings[i].remove();
                    }   
                }
               
            },
            makePageBreak(){
                this.removePageBreak();
                const start = this.$refs.resume_body.getBoundingClientRect().top;
                const page_bottom = this.pageBottom;
                const offset =  start - this.padding;

                const skill_top = this.$refs.skill.getBoundingClientRect().top
                const skill_childs = this.$refs.skill_child;
                if( (skill_top  < page_bottom + offset) && skill_childs) {
                    let skill_first_end = 0;
                     if(Array.isArray(skill_childs)){
                        skill_first_end = skill_childs[0].getBoundingClientRect().bottom;
                    }else{
                        skill_first_end = skill_childs.getBoundingClientRect().bottom;
                    }

                    if (skill_first_end > page_bottom + offset){
                        this.insertBreak(page_bottom, start, skill_top, this.$refs.skill, this.$refs.skill_title, "div");
                    }
                }
                if(Array.isArray(skill_childs)){
                    this.insertBreakToBlock(page_bottom, start, offset, skill_childs)
                }

                const work_top = this.$refs.work_title.getBoundingClientRect().top
                const work_childs = this.$refs.work_child;
                if( (work_top  < page_bottom + offset) && work_childs) {
                    let work_first_end = 0;
                     if(Array.isArray(work_childs)){
                        work_first_end = work_childs[0].getBoundingClientRect().bottom;
                    }else{
                        work_first_end = work_childs.getBoundingClientRect().bottom;
                    }

                    if (work_first_end > page_bottom + offset){
                        this.insertBreak(page_bottom, start, work_top, this.$refs.skill, this.$refs.work_title, "div");
                    }
                }
              
                if(Array.isArray(work_childs)){
                    this.insertBreakToBlock(page_bottom, start, offset, work_childs)
                }

                if(this.resume.resume_educations[0] && this.$refs.education_title){
                    const education_top = this.$refs.education_title.getBoundingClientRect().top
                    const education_childs = this.$refs.education_child;
                    for(let index = 1; index < 3 ; index ++)
                    {
                        if( (education_top  < page_bottom * index + offset)  && (education_top  > page_bottom * (index-1) )){
                            let education_first_end = 0;
                            if(Array.isArray(education_childs)){
                                education_first_end = education_childs[0].getBoundingClientRect().bottom;
                            }else{
                                education_first_end = education_childs.getBoundingClientRect().bottom;
                            }

                            if (education_first_end > page_bottom * index + offset){
                                this.insertBreak(page_bottom * index, start, education_top, this.$refs.work, this.$refs.education_title, "div");
                            }
                        }
                    }
                
                    if(Array.isArray(education_childs)){
                        this.insertBreakToBlock(page_bottom, start, offset, education_childs)
                    }
                }
                
                const hobby_top = this.$refs.hobby.getBoundingClientRect().top
                for(let index = 1; index <= 3 ; index ++)
                {
                    if( (hobby_top  < page_bottom * index + offset)  && (hobby_top  > page_bottom * (index-1) )){
                        const hobby_end = this.$refs.hobby.getBoundingClientRect().bottom;

                        if (hobby_end > page_bottom * index + offset){
                            this.insertBreak(page_bottom * index, start, hobby_top, this.$refs.skill, this.$refs.hobby, "div");
                        }
                    }
                }
            },
            onResize(){
                let page_bottom = 0
                if(this.$refs.resume_body && this.$refs.resume_body.offsetWidth > 800)
                {
                    page_bottom = 1056;
                    this.padding = 75;
                }
                else if(window.innerWidth >=1500){
                    page_bottom = 890.35;
                    this.padding =63.234;
                } else if( window.innerWidth >= 1250){
                    page_bottom = 890.35 * 6 / 6;
                    this.padding =63.234 * 5 / 6;
                }else{
                    page_bottom = 890.35 * 2 / 3;
                    this.padding =63.234 * 2 / 3;
                }
               
                if(this.pageBottom !== page_bottom)
                    this.pageBottom = page_bottom
                    this.makePageBreak();
            },
            insertBreakToBlock(page_bottom, start, offset, childs){
              
                if(Array.isArray(childs)){
                    childs.map( ( element, index ) => {
                        if( index !== 0 ){
                            const top = element.getBoundingClientRect().top;
                            const bottom = element.getBoundingClientRect().bottom;
                            if ( ( top < page_bottom + start) && (bottom > page_bottom + offset) )
                            {
                                this.insertBreak(page_bottom, start, top, childs[index - 1], element );
                            }
                            else if ( ( top < page_bottom * 2 + start ) && (bottom > page_bottom * 2 + offset ) ){
                                this.insertBreak(page_bottom * 2, start, top, childs[index - 1], element );
                            }
                        }
                        return element;
                    })
                }
            },
            stringToArray: function (str) {
                if (str && str.length > 0)
                    return str.split(/\r?\n/)
                return [];
            },

            insertAfter(new_node, existing_node) {
                existing_node.parentNode.insertBefore(new_node, existing_node.nextSibling);
            },

            insertBreak(page_bottom, page_start, current_top , current_node, next_node){
                const margin_top = page_bottom - current_top + page_start - 35;
                let new_node = document.createElement("div");
                new_node.classList.add("html2pdf__page-break")
                new_node.setAttribute("style" ,`margin-top: ${margin_top}px`);
                this.insertAfter(new_node, current_node);

                let name_element = document.createElement("div");
                name_element.innerHTML = this.fullName;
                name_element.classList.add("heading-name")
                name_element.classList.add("text-right")
                name_element.classList.add("heading-bold")
                this.insertAfter(name_element, new_node);
                // next_node.classList.add("page-top");
            },
            dateFormat(date){
                return convertDate(date, this.resume.date_format);
            },
        }
    }
</script>
<style scoped>

</style>