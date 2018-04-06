var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

import Vue from 'vue';
import VueSweetAlert from 'vue-sweetalert';
import InfiniteLoading from 'vue-infinite-loading';
import axios from 'axios';

Vue.component('form-view',
{
    props: ['taxpayer', 'cycle', 'baseurl', 'taxpayercurrency'],
    data() {
        return {
            isList : true,
        }
    }
});
