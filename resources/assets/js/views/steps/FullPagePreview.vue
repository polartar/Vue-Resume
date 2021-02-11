<template>
    <div  >
        <div class="resume-preview-action-links">
            <!-- <el-link type="success"
                :href="'/generate-resume-pdf/' + resume.id + '?preview=true'"
                target="_blank"
                :underline="false">
                Download as PDF
            </el-link> -->

            <button class="button" @click="download">Download as a pdf</button>
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
            :htmlToPdfOptions="{html2canvas:{ y:scrollHeight }}"
            pdf-format="letter"
            pdf-orientation="portrait"
            pdf-content-width="100%"
            ref="html2Pdf"
        > 
              <GoldenStandard  slot="pdf-content"/>           
        </vue-html2pdf>
          
     
    </div>
</template>

<script>
    import VueHtml2pdf from 'vue-html2pdf'
    import {mapState, mapGetters} from 'vuex'
    import GoldenStandard from "../resume-templates/GoldenStandard";
    import Functional from "../resume-templates/Functional";
    import Combination from "../resume-templates/Combination";
    import Recruiter from "../resume-templates/Recruiter";
    import Sidebar from "../resume-templates/Sidebar";
    import debounce from 'lodash.debounce';

    export default {
        components: {Recruiter, Functional, GoldenStandard, Combination, Sidebar, VueHtml2pdf},
        data() {
            return {
                scrollHeight:0,
                scaleStylesObject: {
                    transform: "translate(-50%, -50%) "  + "scale(.5)",
                    transformOrigin: "100% 100%"
                }
            }
        },
        computed: {
            ...mapState([
                'resume',
                'toggleResumePreview',
                'refreshPreview',
            ]),
            ...mapGetters([
                'resumeName',
                'resumeSummary',
            ])
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
            download(){
                // console.log(this.$refs.html2Pdf)
                this.$refs.html2Pdf.generatePdf();
            },
            downloadResume: function () {
                this.$axios.get(`/generate-resume-pdf/${this.resume.id}`)
                    .then(response => {
                        FileDownload(response.data, 'resume.pdf');
                    })
                    .catch();
            },

            // based on  https://css-tricks.com/scaled-proportional-blocks-with-css-and-javascript/
            doResize: function() {
                let container = document.querySelector('.resume-preview-container').offsetWidth - 32
                let resume = 850
                let scale = (container / resume).toFixed(2)
                let translate = ((1 - container / resume) * 100 * -1).toFixed(0)

                this.scaleStylesObject.transform = "translate(" + translate + "%, " + translate + "%) " + "scale(" + scale + ")"
                let baseHeight = document.querySelector('.resume-preview-action-links').offsetHeight + 1100 + 48
                document.querySelector('.resume-preview-container').style.height = window.innerHeight - 60 + 'px';
            },

            refreshiFrame: function() {
                if( document.querySelector('#iframe-resume-preview') ) {
                    document.querySelector('#iframe-resume-preview').src += ''
                }

                console.log('refresh')

                setTimeout(() => {
                    //this.refreshiFrame()
                    // console.log('refresh')
                }, 2000)
            }
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