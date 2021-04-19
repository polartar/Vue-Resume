<template>
    <div class="resume-sidebar" ref='resume_body'>
        <div class="print-paper" ref='print_paper'>
            <span class="name">{{ fullName }}</span>
            <hr/>
            <br/><br/>
            <div class="resume-content">
                <div class="left" ref='left'>
                    <div class='contact-info'>
                        <div class="header section">Contact</div>
                        <div class="sub-header">Phone</div>
                        <div>{{ phone }}</div>
                        <div class="sub-header">Email</div>
                        <div> {{ resume.email}}</div>
                        <div class="sub-header">Address</div>
                        <div>{{ street_1 }}</div>
                        <div>{{ street_2 }}</div>
                        <div>{{ city }}{{city ? "," : ""}} {{ province }} {{ zip }}</div>
                    </div>
                    <div class='mt-20' ref='skill'>
                        <span class="header">Skills</span>
                        <hr/>
                        <div class='skill-column section'  v-for="skill in resume.resume_skill" v-bind:key="skill.id" ref='skill_child'>
                            {{ skill.name }}
                        </div>
                    </div>
                    <div class='mt-20' ref='education' v-if='resume.resume_educations.length!==0'>
                        <div ref='education_title'>
                            <span class="header" ref='education-header'>Education</span>
                            <hr/>
                        </div>

                        <div v-for="education in resume.resume_educations" v-bind:key="education.id" ref='education_child' class='section'>
                            <span class="sub-sub-header">{{ education.degree_received }}</span>
                            {{ education.school_name }}
                            <br/>
                            {{ education.start_date&&education.start_date.substring(0,4) }}-{{ education.end_date ? education.end_date.substring(0,4) : 'Present' }}
                        </div>
                    </div>
                </div>

                <div class="right" ref='right'>
                    <div class=''  ref='summary'>
                        <span class="header">Professional Summary</span>
                        <hr/>
                        <span>{{ resume.resume_summaries[0] &&resume.resume_summaries[0].name }}</span>
                        <br/>
                    </div>

                    <div class='mt-20' ref='work'>
                        <div ref='work_title'>
                            <span class="header">Work Experience</span>
                            <hr/>
                        </div>

                        <div v-for="work in resume.resume_work_experiences" v-bind:key="work.id" ref='work_child' class="section">
                            <span class="sub-header">
                                {{ work.position_title }}
                            </span>
                            <span class="">
                                {{ work.position_company }} | {{work.position_start_date&& work.position_start_date.substring(0,4) }}-{{ work.position_end_date ? work.position_end_date.substring(0,4) : 'Present' }}
                            </span>
                            <!-- <ul v-if="work.resume_descriptions[0]">
                                <li class="" v-for="(item, index) in stringToArray(work.resume_descriptions[0].description)" :key="index" >
                                    {{item}}
                                </li>
                            </ul> -->
                                <div class="" v-for="(item, index) in stringToArray(work.resume_descriptions)" :key="index" >
                                    <ul><li> {{item}} </li></ul>
                                </div>
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
                scale:1,
                limit: 150
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
               this.onResize();
            })
        },
        updated(){
            this.$nextTick(function () {
                setTimeout(this.onResize, 500);
            })
        },
        methods: {
            removePageBreak()
            {
                 let breaktops = document.getElementsByClassName("break-top");
                let len = breaktops.length;
                if(breaktops && len > 0)
                {
                    while(breaktops[0])
                        breaktops[0].remove();
                }

                let breaks = document.getElementsByClassName("html2pdf__page-break");
                len = breaks.length;
                if(breaks)
                {  
                    while(breaks[0])
                        breaks[0].remove();
                }

                let pagetops = document.getElementsByClassName("newpage-top");
                len = pagetops.length;
                if(pagetops && len > 0)
                {  
                    while(pagetops[0])
                        pagetops[0].remove();
                }

            },
            makePageBreak(){
                this.removePageBreak()
                if(!this.$refs.resume_body) {
                    return;
                }
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

                // const work_top = this.$refs.summary.getBoundingClientRect().bottom
                const work_childs = this.$refs.work_child;
                // if( (work_top  < page_bottom + offset) && work_childs) {
                //     let work_first_end = 0;
                //      if(Array.isArray(work_childs)){
                //         work_first_end = work_childs[0].getBoundingClientRect().bottom;
                //     }else{
                //         work_first_end = work_childs.getBoundingClientRect().bottom;
                //     }

                //     if (work_first_end > page_bottom + offset){
                //         this.insertBreak(page_bottom, start, work_top, this.$refs.summary, this.$refs.work_title, "div");
                //     }
                // }
              
                if(Array.isArray(work_childs)){
                    this.insertBreakToBlock(page_bottom, start, offset, work_childs, "work", this.$refs.summary )
                }
     
                if(this.$refs.education&&this.$refs.education.getBoundingClientRect().bottom > page_bottom + start || this.$refs.work.getBoundingClientRect().bottom > page_bottom + start){
                        this.$refs.resume_body.classList.add("fillHeight");
                }else{
                    this.$refs.resume_body.classList.remove("fillHeight");
                }
                
            },
            onResize(){
                let page_bottom = 0
                
                if(this.$refs.resume_body && this.$refs.resume_body.offsetWidth > 800)
                {
                    page_bottom = 1056;
                    this.padding = 75;
                    this.scale = 1;
                 }
                else if(window.innerWidth >=1500){
                    page_bottom = 890.35;
                    this.padding =63.234;
                    this.scale = 0.84313;
                } else if( window.innerWidth >= 1250){
                    page_bottom = 890.35 * 5 / 6;
                    this.padding =63.234 * 5 / 6;
                    this.scale = 0.84313 * 5 / 6;
                }else{
                    page_bottom = 890.35 * 2 / 3;
                    this.padding =63.234 * 2 / 3;
                    this.scale = 0.84313 * 2 / 3;
                }

                if(this.pageBottom !== page_bottom){
                    this.pageBottom = page_bottom
                }
                this.makePageBreak();
            },
            insertBreakToBlock(page_bottom, start, offset, childs, section_title, beforeNode){
                const len = childs.length;
                const tmp_childs = childs;
                let flag = 0;
                if(Array.isArray(childs)){
                    tmp_childs.map( ( element, index ) => {

                            let top = element.getBoundingClientRect().top;
                            if(index !==0) {
                                top = childs[index - 1].getBoundingClientRect().bottom;
                            }

                            let bottom = element.getBoundingClientRect().bottom;
                            let child_details = element.getElementsByTagName("div");
                            
                            if (child_details.length > 0) {
                                const title_bottom = child_details[0].getBoundingClientRect().bottom;
                                if ( ( top < page_bottom + start) && (title_bottom > page_bottom + offset) )
                                {
                                    if (index ===0)
                                        this.insertBreak(page_bottom, start, top + 10, beforeNode);
                                    else 
                                        this.insertBreak(page_bottom, start, top + 10, childs[index - 1] );
                                    flag = 1;   
                                }
                                else if ( ( top < page_bottom * 2 + start ) && (title_bottom > page_bottom * 2 + offset ) ){
                                    if (index ===0)
                                        this.insertBreak(page_bottom * 2, start, top + 10, beforeNode );
                                    else
                                        this.insertBreak(page_bottom * 2, start, top + 10, childs[index - 1] );
                                    
                                    flag = 1;
                                }
                            }

                         if( flag !== 1 )
                        {
                            
                             top = element.getBoundingClientRect().top;
                             bottom = element.getBoundingClientRect().bottom;
                            
                            child_details = element.getElementsByTagName("div");
                            if ( (bottom - top) < this.limit  || (child_details && child_details.length===1)  || !child_details ) {
                                if ( ( top < page_bottom + start) && (bottom > page_bottom + offset) )
                                {
                                    this.insertBreak(page_bottom, start, top, childs[index - 1], section_title );
                                }
                                else if ( ( top < page_bottom * 2 + start ) && (bottom > page_bottom * 2 + offset ) ){
                                    this.insertBreak(page_bottom * 2, start, top, childs[index - 1], section_title );
                                }
                                else if (bottom <= page_bottom + offset) {
                                    if( (index === len - 1) &&(section_title==='skill' ||section_title==='education' || section_title==='work')  ){
                                        if(this.$refs.education){
                                            if((this.$refs.education&&this.$refs.education.getBoundingClientRect().bottom > page_bottom + start) || (this.$refs.work.getBoundingClientRect().bottom > page_bottom + start))
                                            this.insertBreak(page_bottom, start, bottom + 10, childs[index ], section_title );
                                        }
                                        else{
                                            if((this.$refs.skill&&this.$refs.skill.getBoundingClientRect().bottom > page_bottom + start) || (this.$refs.work.getBoundingClientRect().bottom > page_bottom + start))
                                            this.insertBreak(page_bottom, start, bottom + 10, childs[index ], section_title );                                        
                                        }
                                    }
                                }
                            } else {                                
                               this.insertBreakToChildBlock(page_bottom, start -10, offset, child_details); 
                            }
                        }
                        return element;
                    })
                }
            },
            insertBreakToChildBlock(page_bottom, start, offset, childs){
                const len = childs.length;
                for(let i = 1; i < len; i ++) {
                    let element = childs[i];
                    {
                        console.log({i, childs})
                        const top = element.getBoundingClientRect().top;
                        const bottom = element.getBoundingClientRect().bottom;
                        if ( ( top < page_bottom + start) && (bottom > page_bottom + offset) )
                        {
                            this.insertBreak(page_bottom, start, top, childs[i - 1], element );
                            break;
                        }
                        else if ( ( top < page_bottom * 2 + start ) && (bottom > page_bottom * 2 + offset ) ){
                            this.insertBreak(page_bottom * 2, start, top, childs[i - 1], element );
                            break;
                        }
                    }
                }
            },
            // insertBreakToBlock(page_bottom, start, offset, childs, beforeNode){
            //   let flag  = 0;
            //     if(Array.isArray(childs)) {
            //         childs.map( ( element, index ) => {
            //             {
            //                 let top = element.getBoundingClientRect().top;
            //                 if(index !==0) {
            //                     top = childs[index - 1].getBoundingClientRect().bottom;
            //                 }

            //                 let bottom = element.getBoundingClientRect().bottom;
            //                 let child_details = element.getElementsByTagName("div");
                            
            //                 if (child_details.length > 0) {
            //                     const title_bottom = child_details[0].getBoundingClientRect().bottom;
            //                     if ( ( top < page_bottom + start) && (title_bottom > page_bottom + offset) )
            //                     {
            //                         if (index ===0)
            //                             this.insertBreak(page_bottom, start, top, beforeNode);
            //                         else 
            //                             this.insertBreak(page_bottom, start, top, childs[index - 1] );
            //                         flag = 1;   
            //                     }
            //                     else if ( ( top < page_bottom * 2 + start ) && (title_bottom > page_bottom * 2 + offset ) ){
            //                         if (index ===0)
            //                             this.insertBreak(page_bottom * 2, start, top, beforeNode );
            //                         else
            //                             this.insertBreak(page_bottom * 2, start, top, childs[index - 1] );
                                    
            //                         flag = 1;
            //                     }
            //                 }
                            
            //                 if(flag === 0) {
            //                     if(index !==0) {
            //                         top = childs[index - 1].getBoundingClientRect().bottom;
            //                     }
            //                     top = element.getBoundingClientRect().top;
            //                     bottom = element.getBoundingClientRect().bottom;
            //                     child_details = element.getElementsByTagName("div");
            //                     if ( (bottom - top) < this.limit  || (child_details && child_details.length===1)  || !child_details ) {
            //                         if ( ( top < page_bottom + start) && (bottom > page_bottom + offset) )
            //                         {
            //                             if( index ===0 )
            //                                 this.insertBreak(page_bottom, start, top, beforeNode );
            //                             else
            //                                 this.insertBreak(page_bottom, start, top, childs[index - 1] );
            //                         }
            //                         else if ( ( top < page_bottom * 2 + start ) && (bottom > page_bottom * 2 + offset ) ){
            //                             if( index ===0 )
            //                                 this.insertBreak(page_bottom, start, top, beforeNode );
            //                             else 
            //                                 this.insertBreak(page_bottom * 2, start, top, childs[index - 1] );
            //                         }
            //                     } else {
            //                     this.insertBreakToChildBlock(page_bottom, start, offset, child_details); 
            //                     }
            //                 }
                           
            //             }
            //             return element;
            //         })
            //     }
            // },
            // insertBreakToChildBlock(page_bottom, start, offset, childs){
            //     const len = childs.length;
            //     let flag = 0;
            //     for(let i = 1; i < len; i ++) {
            //         if(flag !== 0)
            //             break;
            //         let element = childs[i];
            //         {
            //             const top = childs[i-1].getBoundingClientRect().bottom;
            //             const bottom = element.getBoundingClientRect().bottom;
            //             if ( ( top < page_bottom + start) && (bottom > page_bottom + offset) )
            //             {
            //                 this.insertBreak(page_bottom, start, top, childs[i - 1], element );
            //                 flag = 1;
            //             }
            //             else if ( ( top < page_bottom * 2 + start ) && (bottom > page_bottom * 2 + offset ) ){
            //                 this.insertBreak(page_bottom * 2, start, top, childs[i - 1], element );
            //                 flag = 1;
            //             }
            //         }
            //     }
            // },
            stringToArray: function (str) {
                if (str && str[0] && str[0].description.length > 0)
                    return str[0].description.split(/\r?\n/)
                return [];
            },
            insertAfter(new_node, existing_node) {
                existing_node.parentNode.insertBefore(new_node, existing_node.nextSibling);
            },

            insertBreak(page_bottom, page_start, current_top , current_node, section_title){
                const margin_top = (page_bottom - current_top + page_start - 63);
                let break_top = document.createElement("div");
                break_top.classList.add("break-top")
                break_top.setAttribute("style" ,`margin-top: ${margin_top}px`);
                this.insertAfter(break_top, current_node);

                let new_node = document.createElement("div");
                new_node.classList.add("html2pdf__page-break")
                if(section_title === "education" || section_title === "skill")
                    new_node.classList.add("page-break-left")
                else{
                    new_node.classList.add("page-break-right")
                }
                // new_node.setAttribute("style" ,`margin-top: ${margin_top}px`);
                this.insertAfter(new_node, break_top);

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
