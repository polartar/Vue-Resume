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
    }
}
export default getters;