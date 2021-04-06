const state = {
    resume: {
        resume_summaries: [],
        resume_educations: [],
        resume_work_experiences: [],
        resume_skill : [],
        hobbies: [],
        resume_design:  {},
        linkedin_url:""
    },
    firstName : '',
    lastName : '',
    user: {
        email: '',
    },
    email: '',
    phone: '',
    country: '',
    street_1: '',
    street_2: '',
    city: '',
    province: '',
    zip: '',
    userEmailIds: [],
    userAddressIds: [],
    userPhoneIds: [],
    summary: {},
    resumeDesigns: [],
    toggleResumePreview: false,
    refreshPreview: 0
}
export default state;