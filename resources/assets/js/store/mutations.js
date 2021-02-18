import axios from "axios"
import {Notification} from 'element-ui'

const mutations = {
    updateToggleResumePreview (state, payload) {
        state.toggleResumePreview = payload;
    },
    updateRefreshPreview (state) {
        // console.log(state)
        state.refreshPreview = state.refreshPreview + 1
    },
    updateResume (state, payload) {
        state.resume = payload;
    },
    updateResumeDateFormat (state, payload) {
        state.resume.date_format = payload;
        axios.put('/resume/' + state.resume.id, {
            'date_format': payload,
            'user_id': state.resume.user_id,
            'name': state.resume.name,
        }).then((response) => {
            this.commit('reloadResume');
            state.refreshPreview = state.refreshPreview + 1
            Notification.success({
                title: 'Success',
                message: 'Successfully updated date format!',
            });
        });
    },
    
    updateResumeName (state, payload) {
        state.resume.name = payload;
    },
    updateSummary (state, payload) {
        state.summary = payload;
    },
    updateFirstName (state, payload) {
        state.firstName = payload;
    },
    updateLastName (state, payload) {
        state.lastName = payload;
    },
    updateUserEmail (state, payload) {
        state.user.email = payload;
        if (state.userEmailIds.length === 0) {
            state.email = payload;
        }
    },
    updateResumeEmail (state, payload) {
        // state.resume.email = payload;
        // state.resume = JSON.parse(JSON.stringify(state.resume));
        state.resume = {...state.resume, email: payload}
    },
    updateResumeDesigns (state, payload) {
        state.resumeDesigns = payload;
    },
    deleteNewHobby(state){
        let hobbies = state.resume.hobbies.filter(hobby => hobby.id !== 'new');

        state.resume = {...state.resume, hobbies}
    },
    deleteNewSummary(state){
        let resume_summaries = state.resume.resume_summaries.filter(summary => summary.id !== 'new');

        state.resume = {...state.resume, resume_summaries}
    },
    deleteNewWorkExperience(state){
        let resume_work_experiences = state.resume.resume_work_experiences.filter(work => work.id !== 'new');

        state.resume = {...state.resume, resume_work_experiences}
    },
    deleteNewResumeEducation(state){
        let resume_educations = state.resume.resume_educations.filter(education => education.id !== 'new');

        state.resume = {...state.resume, resume_educations}
    },
    updateCurrentResumeDesign(state, payload){
        state.resume = {...state.resume, resume_design: {...state.resume.resume_design, name: payload}}
    },
    updateCurrentResumeDateFormat(state, payload){
        state.resume = {...state.resume, date_format: payload}
    },
    updateCurrentResumeEducation(state, payload){
         if(payload.id === "new"){
            const tmp = state.resume.resume_educations.filter(education =>  education.id === "new");
            if(tmp.length === 0){
                state.resume.resume_educations.push({
                    id: "new", 
                    ...payload
                })
                state.resume = {...state.resume};
                return;
            }
        }
        
        let resume_educations = state.resume.resume_educations.map(education=>{
            if(education.id === payload.id)
                return {
                    ...education, 
                    ...payload
                };
            else   
                return education
        })
        state.resume = {...state.resume, resume_educations}  
    },
    updateCurrentResumeSummary (state, payload){
        if(payload.id === "new"){
            const tmp = state.resume.resume_summaries.filter(summary =>  summary.id === "new");
            if(tmp.length === 0){
                state.resume.resume_summaries.push({id: "new", name: payload.name})
                state.resume = {...state.resume};
                return;
            }
        }
        
        let resume_summaries = state.resume.resume_summaries.map(summary=>{
            if(summary.id === payload.id)
                return {...summary, name: payload.name};
            else   
                return summary
        })
        state.resume = {...state.resume, resume_summaries}
    },    
    updateCurrentResumeWorkExperience (state, payload){
         if(payload.id === "new"){
            const tmp = state.resume.resume_work_experiences.filter(work =>  work.id === "new");
            if(tmp.length === 0){
                state.resume.resume_work_experiences.push(
                    {
                        id: "new", 
                        position_title: payload.title, 
                        position_company: payload.company,
                        resume_descriptions:[{
                            id: "new",
                            description: payload.description
                        }],
                        position_start_date: payload.start_date,
                        position_end_date: payload.end_date
                    }
                )
                state.resume = {...state.resume};
                return;
            }
        }

        let resume_work_experiences = state.resume.resume_work_experiences.map(work=>{
            if(work.id === payload.id)
                return {
                    ...work,
                    position_title: payload.title, 
                    position_company: payload.company,
                    resume_descriptions:[{
                        id: "new",
                        description: payload.description
                    }],
                    position_start_date: payload.start_date,
                    position_end_date: payload.end_date
                };
            else   
                return work
        })
        state.resume = {...state.resume, resume_work_experiences}
    }, 
    updateCurrentResumeHobby (state, payload){
        if(payload.id === "new"){
            const tmp = state.resume.hobbies.filter(hobby =>  hobby.id === "new");
            if(tmp.length === 0){
                state.resume.hobbies.push({id: "new", name: payload.name})
                state.resume = {...state.resume};
                return;
            }
        }
        
        let hobbies = state.resume.hobbies.map(hobby=>{
            if(hobby.id === payload.id)
                return {...hobby, name: payload.name};
            else   
                return hobby
        })
        state.resume = {...state.resume, hobbies}
    },       
    updateUserEmailIds (state, payload) {
        if (payload == null) {
            state.userEmailIds = null;
        } else {
            state.userEmailIds = payload;
        }
    },
    addUserEmailId (state, payload) {
        this.commit('updateUserEmailIds', payload);
    },
    
    
    updateUserAddressIds (state, payload) {
        if (payload == null) {
            state.userAddressIds = null;
        } else {
            state.userAddressIds = payload;
        }
    },
    addUserAddressId (state, payload) {
        this.commit('updateUserAddressIds', payload);
    },
    
    
    updateUserPhoneIds (state, payload) {
        if (payload == null) {
            state.userPhoneIds = null;
        } else {
            state.userPhoneIds = payload;
        }
    },
    // Only adding if it doesn't already exist.
    addResumePhoneId (state, payload) {
        this.commit('updateUserPhoneIds', payload);
    },
    
    updatePhone (state, payload) {
        state.phone = payload;
    },
    updateCountry (state, payload) {
        state.country = payload;
    },
    updateStreet1 (state, payload) {
        state.street_1 = payload
    },
    updateStreet2 (state, payload) {
        state.street_2 = payload
    },
    updateCity (state, payload) {
        state.city = payload
    },
    updateProvince (state, payload) {
        state.province = payload
    },
    updateZip (state, payload) {
        state.zip = payload
    },
    updateLinkedInUrl (state, payload) {
        state.resume.linkedin_url = payload
    },
    updateAddress (state, payload) {
        this.commit('updateStreet1', payload.street_1);
        this.commit('updateStreet2', payload.street_2);
        this.commit('updateCity', payload.city);
        this.commit('updateProvince', payload.province);
        this.commit('updateCountry', payload.country);
        this.commit('updateZip', payload.postal_code);
    },
    reloadResume (state) {
        axios
            .get('/resume/' + state.resume.id)
            .then(response => {
                state.resume = response.data.resume;
            })
            .catch(error => {
                console.log('error reloading resume: ', error);
            });
    },
    updateResumeSummaries (state, payload) {
        state.resume.resume_summaries = payload;
        axios.put('/resume-summaries', {'summaries': payload});
    },
    updateResumeWorkExperiences (state, payload) {
        state.resume.resume_work_experiences = payload;
        axios.put('/resume-work-experiences', {'work-experiences': payload});
    },
    updateResumeEducations (state, payload) {
        state.resume.resume_educations = payload;
        axios.put('/resume-educations', {'educations': payload});
    },
    updateResumeHobbies (state, payload) {
        state.resume.hobbies = payload;
        axios.put('/hobbies', {'hobbies': payload})
            .then(response => {
                state.refreshPreview = state.refreshPreview + 1
            });
    },
    updateResumeSkills (state, payload) {
        state.resume.skills = payload;
        axios.put('/skills', {'skills': payload})
            .then(response => {
                state.refreshPreview = state.refreshPreview + 1
            });
    }
}

export default mutations