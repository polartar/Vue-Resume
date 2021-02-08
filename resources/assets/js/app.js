import 'es6-promise/auto'
import Vue from 'vue'
import VueRouter from 'vue-router'
import store from "./store/index"
import axios from 'axios'
import Fragment from 'vue-fragment'
// Docs: https://element.eleme.io/#/en-US/component/quickstart
import ElementUI from 'element-ui';

import locale from 'element-ui/lib/locale/lang/en'
// import 'element-ui/lib/theme-chalk/index.css'; // in main scss file

Vue.use(require('vue-moment'));
Vue.use(VueRouter);
Vue.use(ElementUI, {locale});
Vue.use(Fragment.Plugin)

Vue.prototype.$axios = axios;


/* #endregion */

import App from './views/App'
import Home from './views/Home'
import SelectDesign from './views/steps/SelectDesign'
import ContactInformation from './views/steps/ContactInformation'
import ResumeSummary from './views/steps/ResumeSummary'
import WorkExperience from './views/steps/WorkExperience'
import Education from './views/steps/Education'
import Skills from './views/steps/Skills'
import Hobbies from './views/steps/Hobbies'
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
                    path: 'hobbies',
                    name: 'hobbies',
                    component: Hobbies,
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

