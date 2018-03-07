
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


import Vuex from 'vuex';
import vuexI18n from 'vuex-i18n';
import Locales from './vue-i18n-locales.generated.js';

const store = new Vuex.Store();

Vue.use(vuexI18n.plugin, store);

Vue.i18n.add('en', Locales.en);
Vue.i18n.add('de', Locales.de);

// set the start locale to use
Vue.i18n.set(Spark.locale);

require('./components/bootstrap');

window.Vue = require('vue');
window.Vue.use(VueRouter);
window.Vue.use(require('vue-shortkey'));
Vue.use(VueGoodTable);
Vue.use(Datatable);
Vue.use(require('vue-shortkey'))

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
