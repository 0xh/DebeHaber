
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
import Datatable from './components/datatable.vue';
import Vue from 'vue';
import VueGoodTable from 'vue-good-table';

window.Vue = require('vue');
window.Vue.use(VueRouter);
window.Vue.use(require('vue-shortkey'));
Vue.use(VueGoodTable);

const routes = [
    {
        path: '/',
        components: {
            SearchBox : SearchBox,
            Datatable:Datatable
        }
    },
]

const router = new VueRouter({ routes })

var app = new Vue({
    router,
    mixins: [require('spark')]
});
