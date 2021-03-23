function capitalize(s) {
    if (typeof s !== 'string') return ''
    return s.charAt(0).toUpperCase() + s.slice(1)
}

const  getters = {
    resumeName: state => {
        return state.resume.name;
    },
    resumeSummary: state => {
        return state.summary.name;
    },
    resumeId: state => {
        return state.resume.id
    },
    fullName: state => {
        return capitalize(state.firstName) + ' ' + capitalize(state.lastName);
    },
    designType: state => {
        if(state.resume.resume_design.name === 'Golden Standard')
            state.resume.resume_design.name = 'Gold Standard';
        return state.resume.resume_design.name;
    }
}
export default getters;