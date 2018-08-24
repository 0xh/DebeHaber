
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
import SearchBoxTaxPayer from './components/search-taxpayer.vue';
import SearchBox from './components/searchbox.vue';
import SearchBoxAccount from './components/searchboxaccount.vue';
import Vue from 'vue';

// import ElementUI from 'element-ui';
// import 'element-ui/lib/theme-chalk/index.css';
// import locale from 'element-ui/lib/locale/lang/es';

import Vuex from 'vuex';
import vuexI18n from 'vuex-i18n';
import Locales from './vue-i18n-locales.generated.js';

import Bars from 'vuebars'
import Trend from 'vuetrend';

import Buefy from 'buefy'
import 'buefy/lib/buefy.css'
import Icon from 'buefy/src/components/icon';

const store = new Vuex.Store();

Vue.component(Icon.name, Icon);
Vue.use(Buefy, {
    defaultIconPack: 'fas',

    // ...
})
Vue.use(vuexI18n.plugin, store);
Vue.use(Bars)
Vue.use(Trend);
// Vue.use(ElementUI, {locale});

//Vue.config.productionTip = true

// Vue.i18n.add('en', Locales.en);
// Vue.i18n.add('de', Locales.de);

// set the start locale to use
Vue.i18n.set(Spark.locale);

window.Vue = require('vue');
window.Vue.use(VueRouter);
window.Vue.use(require('vue-shortkey'));
Vue.use(require('vue-shortkey'))

// Passport Components
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

const routes = [
    {
        path: '/',
        components: {
            SearchBox : SearchBox,
            SearchBoxTaxPayer : SearchBoxTaxPayer,
            SearchBoxAccount : SearchBoxAccount,
        }
    },
]

const router = new VueRouter({ routes })

var app = new Vue({
    router,
    mixins: [require('spark')]
});
