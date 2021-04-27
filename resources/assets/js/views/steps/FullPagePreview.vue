<template>
    <div  >
        <div class="resume-preview-action-links">
            <!-- <el-link type="success"
                :href="'/generate-resume-pdf/' + resume.id + '?preview=true'"
                target="_blank"
                :underline="false">
                Download as PDF
            </el-link> -->

            <button class="button" @click="downloadPdf">Download as a pdf</button>
            <button class="button word-button" @click="downloadWord" v-if="designType==='Functional'">Download as a word</button>
        </div>
        <!-- <div v-if="resume.resume_design" class="resume-container" :style="scaleStylesObject">
            <golden-standard v-if="resume.resume_design.name === 'Golden Standard'"></golden-standard>
            <functional v-if="resume.resume_design.name === 'Functional'"></functional>
            <combination v-if="resume.resume_design.name === 'Combination'"></combination>
            <recruiter v-if="resume.resume_design.name === 'Recruiter'"></recruiter>
            <sidebar v-if="resume.resume_design.name === 'Sidebar'"></sidebar>
        </div> -->

        <!-- <div class="resume-container" :style="scaleStylesObject">
            <iframe v-if="resume.id" id="iframe-resume-preview" width="850" height="1100" :src="'/generate-resume-pdf/' + resume.id + '?page=true'"></iframe>
        </div> -->

        <!-- :htmlToPdfOptions="{html2canvas:{ y:scrollHeight }}" -->
         <vue-html2pdf
            :show-layout="false"
            :float-layout="false"
            :enable-download="true"
            :preview-modal="true"
            :filename="resume.id"
            :pdf-quality="2"
            :manual-pagination="true"
            :htmlToPdfOptions="{html2canvas:{ y:scrollHeight, scale:4 }}"
            pdf-format="letter"
            pdf-orientation="portrait"
            pdf-content-width="100%"
            ref="html2Pdf"
        > 
              <div slot="pdf-content">           
                  <Combination v-if="designType==='Combination'"/>
                  <Recruiter v-if="designType==='Recruiter'"/>
                  <Sidebar v-if="designType==='Sidebar'"/>
                  <GoldenStandard v-if="designType==='Gold Standard'" />
                  <Functional v-if="designType==='Functional'" />
              </div>
        </vue-html2pdf>
          
     
    </div>
</template>

<script>
    import VueHtml2pdf from 'vue-html2pdf'
    // :htmlToPdfOptions="{html2canvas:{ y:scrollHeight }, image:{type: 'png', quality: 1}}"
    import {mapState, mapGetters} from 'vuex'
    import GoldenStandard from "../resume-templates/GoldenStandard";
    import Combination from "../resume-templates/Combination";
    import Recruiter from "../resume-templates/Recruiter";
    import Sidebar from "../resume-templates/Sidebar";
    import Functional from '../resume-templates/Functional';
    import debounce from 'lodash.debounce';
    import { Component, Prop, Vue } from "vue-property-decorator";
    import docxtemplater from 'docxtemplater';
    import JSZip from 'jszip';
    import JSzipUtils from 'jszip-utils';
    import  saveAs  from 'file-saver';
    import {convertDate} from "../../services/utility.js"
    export default {
        components: {Recruiter, GoldenStandard, Combination, Sidebar, Functional, VueHtml2pdf},
        data() {
                Functional
            return {
                scrollHeight:0,
                scaleStylesObject: {
                    transform: "translate(-50%, -50%) "  + "scale(.5)",
                    transformOrigin: "100% 100%"
                },
                design_type: "Gold Standard",
            }
        },
        computed: {
            ...mapState([
                'resume',
                'toggleResumePreview',
                'refreshPreview',
                'phone',
                'street_1',
                'street_2',
                'city',
                'province',
                'zip',
                'country',
            ]),
            ...mapGetters([
                'designType',
                'resumeSummary',
                'fullName'
            ])
        },
        watch:{
            resume(value){
                console.log(value.resume_design)
               if(value.resume_design)
                this.design_type = value.resume_design.name;
            }
        },
        mounted() {
            this.doResize()
            this.refreshiFrame()
                 // https://stackoverflow.com/questions/45437827/how-to-use-listeners-in-vue-js-for-events-like-scroll-and-windows-resizing
            window.addEventListener('resize', this.doResize)
        },
        created(){
            this.handleDebouncedScroll = debounce(this.handleScroll, 100);
            window.addEventListener("scroll", this.handleDebouncedScroll);
        },
        beforeDestroy(){
            window.removeEventListener('scroll', this.handleDebouncedScroll)
        },
        methods: {
            handleScroll(event){
                this.scrollHeight =window.scrollY  
             },
            downloadPdf(){
                this.$refs.html2Pdf.generatePdf();
            },
            downloadWord(){
                this.createAndSaveDocument();
            },
            loadFile(url ,callback){
                JSzipUtils.getBinaryContent(url,callback);
            },
            createAndSaveDocument(){
                /*
                *   This required JSON dataset must be fetched from the backend API.
                *   The tags in the template will be replaced by these data.
                *   For demonstrations, I have hardcoded the tesdt dataset
                */
                if (!this.resume) {
                    return;
                }

                let dataset = {
                summary: [    
                ],
                workExperiences: [    
                ],
                educations: [    
                ],
                skills: [    
                ],
                hobbies: [    
                ],
                fullname: this.fullName,
                street_1: this.street_2? this.street_2: "",
                street_2: this.street_2? this.street_2: "",
                city: this.street_2? this.street_2: "",
                street_1: this.street_2? this.street_2: "",
                street_1: this.street_2? this.street_2: "",
                phone: this.phone? this.phone: "",
                email: this.resume.email? this.resume.email: "",
                linkedin: this.resume.linkedin_url? this.resume.linkedin_url: ""
                };

                if (this.designType === "Sidebar") {
                    dataset.summary = this.resume.resume_summaries[0].name;
                } else {
                    this.resume.resume_summaries.forEach(summary => {
                        dataset.summary.push({name:summary.name});
                    });
                }
                
                this.resume.resume_work_experiences.forEach(work => {
                     dataset.workExperiences.push(work);
                });
                
                this.resume.resume_educations.forEach(education => {
                     dataset.educations.push(education)
                });
                
                if (this.designType === 'Sidebar') {
                    dataset.educations = dataset.educations.map(education => {
                        return {
                            ...education,
                            date: education.start_date&&education.start_date.substring(0,4) + "-" + education.end_date ? education.end_date.substring(0,4) : 'Present'
                        }
                    })
                    dataset.workExperiences = dataset.workExperiences.map(work => {
                        return {
                            ...work,
                            date: work.position_start_date&& work.position_start_date.substring(0,4) + "-" + work.position_end_date ? work.position_end_date.substring(0,4) : 'Present'
                        }
                    })   
                } else if (this.designType !== 'Functional') {
                     dataset.educations = dataset.educations.map(education => {
                        return {
                            ...education,
                            start_date: this.dateFormat(education.start_date),
                            end_date: this.dateFormat(education.end_date)
                        }
                    })
                    dataset.workExperiences = dataset.workExperiences.map(work => {
                        return {
                            ...work,
                            position_start_date: this.dateFormat(work.position_start_date),
                            position_end_date: this.dateFormat(work.position_end_date)
                        }
                    })
                }

                if (this.designType === "Combination" || this.designType === "Sidebar") {
                    this.resume.resume_skill.forEach(skill => {
                        dataset.skills.push({name: skill.name})
                    });
                } else {
                     const skills = this.resume.resume_skill;
                    const count = skills.length;
                    for(let i = 0; i < count; i = i + 3) {
                        let name1 = "", name2 = "", name3 = "";
                        if (skills[i]) {
                            name1 = skills[i].name;
                        }
                        if (skills[i+1]) {
                            name2 = skills[i+1].name;
                        }
                        if (skills[i+2]) {
                            name3 = skills[i+2].name;
                        }
                        dataset.skills.push({name1, name2, name3});
                    }
                }
               
                this.resume.hobbies.forEach(hobby => {
                     dataset.hobbies.push(hobby)
                });
                
                let filename = "gold";
                if (this.designType === 'Functional') {
                    filename = "functional";
                } else if (this.designType ==='Recruiter') {
                    filename = "recruiter";
                } else if (this.designType ==='Combination') {
                    filename = "combination";
                } else if (this.designType ==='Sidebar') {
                    filename = "sidebar";
                }
                /* *
                * The template's path must be passed as an arguement .
                * This path can be either a URL(as  in the commented line) or a path relative to the Public folder
                * For testing, I have created a folder named  "ReportTemplates" inside the public folder and it contains my sample
                * template named "template1.docx" .
                * */
                // this.loadFile("https://docxtemplater.com/tag-example.docx",function(error: any,content : any){
                this.loadFile(`/ResumeTemplates/${filename}.docx`,function(error, content){
                    if (error) { 
                    throw error
                    };
                    let zip = new JSZip(content);
                    let doc = new docxtemplater().loadZip(zip)
                    doc.setData(dataset)
                    try {
                        doc.render()
                    }
                    catch (error) {
                        let e = {
                            message: error.message,
                            name: error.name,
                            stack: error.stack,
                            properties: error.properties,
                        }
                        console.log(JSON.stringify({error: e}));
                        // The error thrown here contains additional information when logged with JSON.stringify (it contains a property object).
                        throw error;
                    }
                    // docx generating
                    let out = doc.getZip().generate({
                        type:"blob",
                        mimeType: "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                        })
                    saveAs(out,`MyDocument.docx`);    // You can pass this blob to a custom file saver component in the project.  
                });
            },
            // downloadResume: function () {
            //     this.$axios.get(`/generate-resume-pdf/${this.resume.id}`)
            //         .then(response => {
            //             FileDownload(response.data, 'resume.pdf');
            //         })
            //         .catch();
            // },

            // based on  https://css-tricks.com/scaled-proportional-blocks-with-css-and-javascript/
            doResize: function() {
                // let container = document.querySelector('.resume-preview-container').offsetWidth - 32
                // let resume = 850
                // let scale = (container / resume).toFixed(2)
                // let translate = ((1 - container / resume) * 100 * -1).toFixed(0)

                // this.scaleStylesObject.transform = "translate(" + translate + "%, " + translate + "%) " + "scale(" + scale + ")"
                // let baseHeight = document.querySelector('.resume-preview-action-links').offsetHeight + 1100 + 48
                // document.querySelector('.resume-preview-container').style.height = window.innerHeight - 60 + 'px';
            },

            refreshiFrame: function() {
                if( document.querySelector('#iframe-resume-preview') ) {
                    document.querySelector('#iframe-resume-preview').src += ''
                }
            },
            dateFormat(date){
                return convertDate(date, this.resume.date_format);
            },
        },
        watch: {
            toggleResumePreview: function() {
                this.doResize()
            },

            refreshPreview: function() {
                this.refreshiFrame()
            }
        }
    }
</script>
<style scoped>

.page-break {
  page-break-after: always;
}
</style>