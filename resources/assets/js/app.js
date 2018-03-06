
/*
 |--------------------------------------------------------------------------
 | Laravel Spark Bootstrap
 |--------------------------------------------------------------------------
 |
 | First, we will load all of the "core" dependencies for Spark which are
 | libraries such as Vue and jQuery. This also loads the Spark helpers
 | for things such as HTTP calls, forms, and form validation errors.
 |
 | Next, we'll create the root Vue application for Spark. This will start
 | the entire application and attach it to the DOM. Of course, you may
 | customize this script as you desire and load your own components.
 |
 */

require('spark-bootstrap');
require('./components/bootstrap');

import VueRouter from 'vue-router';
import SearchBox from './components/searchbox.vue';
import SearchBoxAccount from './components/searchboxaccount.vue';
import create from './components/create.vue';
import List from './components/table.vue';
import Vue from 'vue';
import VueGoodTable from 'vue-good-table';
import Datatable from 'vue2-datatable-component';
import VeeValidate from 'vee-validate';
import VueInternalization from 'vue-i18n';
import Locales from './vue-i18n-locales.generated.js';

window.Vue = require('vue');
window.Vue.use(VueRouter);
window.Vue.use(require('vue-shortkey'));
Vue.use(VueGoodTable);
Vue.use(Datatable);
Vue.use(require('vue-shortkey'))
Vue.use(VeeValidate);
Vue.use(VueInternalization);

Vue.config.lang = 'en';
Object.keys(Locales).forEach(function (lang) {
  Vue.locale(lang, Locales[lang])
});

const routes = [
    {
        path: '/',
        components: {
            SearchBox : SearchBox,
            SearchBoxAccount:SearchBoxAccount,
            Datatable:Datatable,
            create:create,
            List:List
        }
    },
]

const router = new VueRouter({ routes })

var app = new Vue({
    router,
    mixins: [require('spark')]
});
