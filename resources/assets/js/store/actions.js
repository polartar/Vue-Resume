import axios from "axios"
import {Notification} from 'element-ui'
import store from "./index"
const actions ={
    updateResumeSummaryOrder: (context, resumeSummaries) => {
        resumeSummaries.forEach( (summary, index) => {
            summary.order = index + 1;
        })

        context.commit('updateResumeSummaries', resumeSummaries);
    },
    updateResumeWorkExperienceOrder: (context, resumeWorkExperiences) => {
        resumeWorkExperiences.forEach( (workExperience, index) => {
            workExperience.order = index + 1;
        })

        context.commit('updateResumeWorkExperiences', resumeWorkExperiences);
    },
    updateResumeEducationOrder: (context, resumeEducations) => {
        resumeEducations.forEach( (education, index) => {
            education.order = index + 1;
        })

        context.commit('updateResumeEducations', resumeEducations);
    },
    updateResumeHobbiesOrder: (context, hobbies) => {
        hobbies.forEach( (hobby, index) => {
            hobby.order = index + 1;
        })

        context.commit('updateResumeHobbies', hobbies)
    },
    updateResumeSkillsOrder: (context, skills) => {
        skills.forEach( (skill, index) => {
            skill.sort_order = index + 1;
        })

        context.commit('updateResumeSkills', skills)
    },

    updateResumeDateFormat: (context, dateFormat) => {
        context.commit('updateResumeDateFormat', dateFormat);
    },
    /**
     * Globally available put request
     *
     * Parameters:
     *  payload: must contain route, payload, successMessage, and commits
     *
     * Returns:
     *  true/false depending on success
     */
    axiosPutRequest: async (context, payload) => {
        console.log({payload})
        return await axios.put(payload.route, payload.payload)
            .then(response => {
                console.log({response})
                if (payload.commits)
                    payload.commits.forEach( (pCommit) => {
                        store.commit(pCommit, response.data.id);
                    });
                if (payload.successMessage)
                    Notification.success({ title: 'Success', message: payload.successMessage });
                return true;
            })
            .catch(error => {
                Notification.error({message: 'Uh oh, we had some trouble with that'});
                return false;
            });
    },

    /**
     * Globally available put request
     *
     * Parameters:
     *  payload: must contain route, payload, successMessage, and commits
     *
     * Returns:
     *  true/false depending on success
     */
    axiosPatchRequest: async (context, payload) => {
        return await axios.patch(payload.route, payload.payload)
            .then(response => {
                if (payload.commits)
                    payload.commits.forEach( (pCommit) => {
                        store.commit(pCommit, response.data.id);
                    });
                if (payload.successMessage)
                    Notification.success({ title: 'Success', message: payload.successMessage });
                return true;
            })
            .catch(error => {
                Notification.error({message: 'Uh oh, we had some trouble with that'});
                return false;
            });
    },
    /**
     * Globally available post request
     *
     * Parameters:
     *  payload: must contain route, payload, successMessage, and commits
     *
     * Returns:
     *  true/false depending on success
     */
    axiosPostRequest: async (context, payload) => {
        return await axios.post(payload.route, payload.payload)
            .then(response => {
                if (payload.commits)
                    payload.commits.forEach( (pCommit) => {
                        store.commit(pCommit, response.data.id);
                    });
                if (payload.successMessage)
                    Notification.success({ message: payload.successMessage });
                return true;
            })
            .catch(error => {
                Notification.error({message: 'Uh oh, we had some trouble with that'});
                return false;
            });
    },
    /**
     * Globally available delete request
     *
     * Parameters:
     *  payload: must contain route, payload, successMessage, and commits
     *
     * Returns:
     *  true/false depending on success
     */
    axiosDeleteRequest: async (context, payload) => {
        return await axios.delete(payload.route)
            .then(response => {
                if (payload.commits)
                    payload.commits.forEach( (pCommit) => {
                        store.commit(pCommit, response.data.id);
                    });
                if (payload.successMessage)
                    Notification.success({ message: payload.successMessage });
                return true;
            })
            .catch(error => {
                Notification.error({message: 'Uh oh, we had some trouble with that'});
                return false;
            });
    }
}
export default actions;