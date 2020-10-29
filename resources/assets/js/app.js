import 'es6-promise/auto'

import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import axios from 'axios'

// Docs: https://element.eleme.io/#/en-US/component/quickstart
import ElementUI from 'element-ui';
import {Notification} from 'element-ui'
import locale from 'element-ui/lib/locale/lang/en'
// import 'element-ui/lib/theme-chalk/index.css'; // in main scss file

Vue.use(VueRouter);
Vue.use(ElementUI, {locale});
Vue.use(Vuex);
Vue.prototype.$axios = axios;

/* #region(collapsed) Store */
const store = new Vuex.Store({
    state: {
        resume: {},
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
        toggleResumePreview: false
    },
    mutations: {
        updateToggleResumePreview (state, payload) {
            state.toggleResumePreview = payload;
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
        updateResumeDesigns (state, payload) {
            state.resumeDesigns = payload;
        },


        updateUserEmailIds (state, payload) {
            if (payload == null) {
                state.userEmailIds = [];
            } else {
                state.userEmailIds = payload;
            }
        },
        addUserEmailId (state, payload) {
            let userEmailIds = state.userEmailIds;
            if (userEmailIds.length === 0) {
                this.commit('updateUserEmailIds', [payload]);
            } else {
                if (userEmailIds.indexOf(payload) === -1) {
                    userEmailIds.push(payload);
                    this.updateUserEmailIds(userEmailIds);
                }
            }
        },


        updateUserAddressIds (state, payload) {
            if (payload == null) {
                state.userAddressIds = [];
            } else {
                state.userAddressIds = payload;
            }
        },
        addUserAddressId (state, payload) {
            let userAddressIds = state.userAddressIds;
            if (userAddressIds.length === 0) {
                this.commit('updateUserAddressIds', [payload]);
            } else {
                if (userAddressIds.indexOf(payload) === -1) {
                    userAddressIds.unshift(payload);
                    this.commit('updateUserAddressIds', userAddressIds);
                }
            }
        },


        updateUserPhoneIds (state, payload) {
            if (payload == null) {
                state.userPhoneIds = [];
            } else {
                state.userPhoneIds = payload;
            }
        },
        // Only adding if it doesn't already exist.
        addUserPhoneId (state, payload) {
            let userPhoneIds = state.userPhoneIds;
            if (userPhoneIds.length === 0) {
                this.commit('updateUserPhoneIds', [payload]);
            } else {
                if (userPhoneIds.indexOf(payload) === -1) {
                    userPhoneIds.push(payload);
                    this.commit('updateUserPhoneIds', userPhoneIds);
                }
            }
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
                    console.log(response.data.resume);
                    state.resume = response.data.resume;
                })
                .catch(error => {
                    console.log('error reloading resume: ', error);
                });
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
            axios.put('/hobbies', {'hobbies': payload});
        }
    },
    getters: {
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
    },
    actions: {
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
            return await axios.put(payload.route, payload.payload)
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
});
/* #endregion */

import App from './views/App'
import Home from './views/Home'
import SelectDesign from './views/steps/SelectDesign'
import ContactInformation from './views/steps/ContactInformation'
import ResumeSummary from './views/steps/ResumeSummary'
import WorkExperience from './views/steps/WorkExperience'
import Education from './views/steps/Education'
import Skills from './views/steps/Skills'
import CustomizeDesign from './views/steps/CustomizeDesign'
import FullPagePreview from './views/steps/FullPagePreview'


require('./fontawesome');
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
Vue.component('font-awesome-icon', FontAwesomeIcon);


const base_path = '/resume-builder/'
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: base_path + '/',
            name: 'home',
            component: Home,
            children: [
                {
                    path: 'select-design',
                    name: 'select-design',
                    component: SelectDesign,
                },
                {
                    path: 'contact-information',
                    name: 'contact-information',
                    component: ContactInformation,
                },
                {
                    path: 'resume-summary',
                    name: 'resume-summary',
                    component: ResumeSummary,
                },
                {
                    path: 'work-experience',
                    name: 'work-experience',
                    component: WorkExperience,
                },
                {
                    path: 'education',
                    name: 'education',
                    component: Education,
                },
                {
                    path: 'skills',
                    name: 'skills',
                    component: Skills,
                },
                {
                    path: 'customize-design',
                    name: 'customize-design',
                    component: CustomizeDesign,
                },
                {
                    path: 'full-page-preview',
                    name: 'full-page-preview',
                    component: FullPagePreview,
                },
            ]
        },
    ],
});

function hasQueryParams(route) {
    return !!Object.keys(route.query).length
}

router.beforeEach((to, from, next) => {
    if(!hasQueryParams(to) && hasQueryParams(from)){
        next({name: to.name, query: from.query});
    } else {
        next()
    }
})

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store,
});

function capitalize(s) {
    if (typeof s !== 'string') return ''
    return s.charAt(0).toUpperCase() + s.slice(1)
}
