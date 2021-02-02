<template>
    <div>
        {{userEmailIds}}
        <h4>{{firstName}} {{lastName}}</h4>
        <div><h5>Summary</h5></div>
        <div class='contact'>
            <div>{{city}},{{province}}</div>
            <div>{{phone}}</div>
            <div>{{resume.email}}</div>
            <div>{{resume.linkedin_url}}</div>
        </div>
        <div class="sheet padding-10mm" v-for="summary in resume.resume_summaries" :key="summary.id">
            <div :class="summary.bullet_point?'bullet':''">{{summary.name}}</div>     
        </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
    computed:{
        ...mapState([
            'resume',
            'firstName',
            'lastName',
            'phone',
            'street_1',
            'street_2',
            'city',
            'province',
            'country',
            'zip',
            'userEmailIds',
            'userAddressIds',
            'userPhoneIds',
            'toggleResumePreview',
            'refreshPreview',
        ]),
    },
    mounted(){
        console.log(this.resume.resume_summaries)
    }
    
};
</script>

<style>
.bullet{
    display: list-item;
    list-style-type: square;
}
</style>
