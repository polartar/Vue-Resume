<template>
    <div class="resume-sidebar" ref='resume_body'>
        <div class="print-paper">
            <span class="name">{{ fullName }}</span>
            <hr/>
            <br/><br/>
            <div class="resume-content">
                <div class="left">
                    <div class='contact-info'>
                        <span class="header">Contact</span>
                        <hr/>
                   
                        <span class="sub-header">Phone</span>
                        <span>{{ phone }}</span>
                        <span class="sub-header">Email</span>
                        <span>{{ email }}</span>
                        <span class="sub-header">Website</span>
                        <span>TODO: Make website form</span>
                        <span class="sub-header">Address</span>
                        <span>{{ street_1 }}{{ street_2 ? ", " + street_2 : ''}}</span>
                        <br/>
                        <span>{{ city }}, {{ province }} {{ zip }}</span>
                    </div>
                    <div class='skills' ref='skill'>
                        <span class="header">Skills</span>
                        <hr/>
                        <div class='skill-column section'  v-for="skill in resume.resume_skill" v-bind:key="skill.id" ref='skill-child'>
                            {{ skill.name }}
                        </div>
                    </div>
                    <div class='education' ref='education'>
                        <div ref='education_title'>
                            <span class="header" ref='education-header'>Education</span>
                            <hr/>
                        </div>

                        <div v-for="education in resume.resume_educations" v-bind:key="education.id" ref='education_child' class='section'>
                            <span class="sub-sub-header">{{ education.degree_received }}</span>
                            {{ education.school_name }}
                            <br/>
                            {{ education.start_date.substring(0,4) }}-{{ education.end_date ? education.end_date.substring(0,4) : 'Present' }}
                        </div>
                    </div>
                </div>

                <div class="right">
                    <div class='summary' v-if="resume.resume_summaries[0]">
                        <span class="header">Professional Summary</span>
                        <hr/>
                        <span>{{ resume.resume_summaries[0].name }}</span>
                        <br/>
                    </div>

                    <div class='workexpierience' ref='work'>
                        <div ref='work_title'>
                            <span class="header">Work Experience</span>
                            <hr/>
                        </div>

                        <div v-for="work in resume.resume_work_experiences" v-bind:key="work.id" ref='work_child' class="section">
                            <span class="sub-header">
                                {{ work.position_title }}
                            </span>
                            <span class="">
                                {{ work.position_company }} | {{ work.position_start_date.substring(0,4) }}-{{ work.position_end_date ? work.position_end_date.substring(0,4) : 'Present' }}
                            </span>
                            <ul v-if="work.resume_descriptions[0]">
                                <li class="" v-for="(item, index) in stringToArray(work.resume_descriptions[0].description)" :key="index" >
                                    {{item}}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapGetters} from 'vuex'

    export default {
         data(){
            return {
                pageBottom: 0,
                padding:0,
            }
        },
        computed: {
            ...mapState([
                'email',
                'phone',
                'street_1',
                'street_2',
                'city',
                'province',
                'zip',
                'country',
                'summary',
                'resume',
            ]),
            ...mapGetters([
                'fullName',
            ])
        },
        created(){
             window.addEventListener("resize", this.onResize);
        },
        mounted() {
             this.$nextTick(function () {
              //  this.onResize();
            })
        },
        updated(){
            this.$nextTick(function () {
                this.onResize();
            })
        },
        methods: {
            removePageBreak()
            {
                let breaks = document.getElementsByClassName("html2pdf__page-break");
                let len = breaks.length;
                if(breaks)
                {
                    for(let i = 0 ; i < len; i++){
                        if(breaks[i])
                          breaks[i].remove();
                    }   
                }

                let pagetops = document.getElementsByClassName("newpage-top");
                len = pagetops.length;
                if(pagetops && len > 0)
                {
                    for(let i = 0 ; i < len; i++){
                        if(pagetops[i])
                            pagetops[i].remove()
                    }   
                }

                // breaks = document.getElementsByClassName("html2pdf__page-break");
                // len = breaks.length;
                // if(len){
                //     breaks[0].remove();
                // }

                // pagetops = document.getElementsByClassName("newpage-top");
                // len = pagetops.length;
                // if(len){
                //     pagetops[0].remove();
                // }
 
            },
            makePageBreak(){
                this.removePageBreak()
                const start = this.$refs.resume_body.getBoundingClientRect().top;
                const page_bottom = this.pageBottom;
                const offset =  start - this.padding;

                const skill_childs = this.$refs.skill_child;
                if(Array.isArray(skill_childs)){
                    this.insertBreakToBlock(page_bottom, start, offset, skill_childs, "skill")
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
                                this.insertBreak(page_bottom * index, start, education_top, this.$refs.skill, this.$refs.education_title, "div");
                            }
                        }
                    }
                
                    if(Array.isArray(education_childs)){
                        this.insertBreakToBlock(page_bottom, start, offset, education_childs, "education")
                    }
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
                        this.insertBreak(page_bottom, start, work_top, this.$refs.summary, this.$refs.work_title, "div");
                    }
                }
              
                if(Array.isArray(work_childs)){
                    this.insertBreakToBlock(page_bottom, start, offset, work_childs, "work")
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
            insertBreakToBlock(page_bottom, start, offset, childs, section_title){
                const len = childs.length;
                const tmp_childs = childs;
                if(Array.isArray(childs)){
                    tmp_childs.map( ( element, index ) => {
                        if( index !== 0 ){
                            const top = element.getBoundingClientRect().top;
                            const bottom = element.getBoundingClientRect().bottom;
                            if ( ( top < page_bottom + start) && (bottom > page_bottom + offset) )
                            {
                                this.insertBreak(page_bottom, start, top, childs[index - 1], section_title );
                            }
                            else if ( ( top < page_bottom * 2 + start ) && (bottom > page_bottom * 2 + offset ) ){
                                this.insertBreak(page_bottom * 2, start, top, childs[index - 1], section_title );
                             }
                             else if (bottom <= page_bottom + offset) {
                                if( (index === len - 1) && ((section_title ==="education")||(section_title ==="work")) ){
                                    this.insertBreak(page_bottom, start, bottom + 10, childs[index ], section_title );
                                }
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

            insertBreak(page_bottom, page_start, current_top , current_node, section_title){
                const margin_top = page_bottom - current_top + page_start - 30;
                let new_node = document.createElement("div");
                new_node.classList.add("html2pdf__page-break")
                if(section_title === "education")
                    new_node.classList.add("page-break-left")
                else{
                    new_node.classList.add("page-break-right")
                }
                new_node.setAttribute("style" ,`margin-top: ${margin_top}px`);
                this.insertAfter(new_node, current_node);

                // next_node.classList.add("page-top");
                let page_top = document.createElement("div");
                page_top.classList.add("newpage-top")
                this.insertAfter(page_top, new_node);
            },
            dateFormat(date){
                return convertDate(date, this.resume.date_format);
            },
        }
    }
</script>
